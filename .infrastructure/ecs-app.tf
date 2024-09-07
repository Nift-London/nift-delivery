resource "aws_ecr_repository" "reg" {
  name = "${var.environment}-${var.application_name}"
}

module "dave" {
  source  = "registry.terraform.io/l4gdev/ecs-service/aws"
  version = "0.3.4"

  application_config = {
    name        = var.application_name
    environment = var.environment
    cpu         = 0,
    memory      = 1024,
    port        = 5000
    image       = var.backend_image,
    nginx_image = var.nginx_image
    environments_variables = merge(
      local.full_app_envs,
        {ENTRY_POINT="php_fpm"}
    )
  }
    list_of_secrets_in_secrets_manager_to_load = local.list_of_secrets_in_secrets_manager_to_load
  aws_alb_listener_rule_conditions = [
    {
      type   = "host_header",
      values = var.domains
    }
  ]

  health_checks = [
    {
      enabled             = true
      healthy_threshold   = 5
      interval            = 10
      matcher             = 302
      path                = "/"
      timeout             = 5
      unhealthy_threshold = 5
    }
  ]

  ecs_settings = {
    ecs_launch_type  = "EC2",
    ecs_cluster_name = local.ecs_cluster_name,
    run_type         = "WEB",
    lang             = "PHP",
  }

  alb_listener_arn         = data.terraform_remote_state.backend.outputs.alb_arn
  alb_deregistration_delay = 30

  tags = {
    Env     = var.environment
    Service = var.application_name
  }

  service_policy = data.aws_iam_policy_document.app_policy.json
  vpc_id         = local.vpc.vpc_id

  deployment = {
    first_deployment_desired_count = 1
    minimum_healthy_percent        = 50
    maximum_healthy_percent        = 200
    enable_asg                     = false
  }
}


data "aws_iam_policy_document" "app_policy" {
  statement {
    actions = [
#      "sqs:*",
#      "sns:*",
      "s3:*",
      "ses:*"
    ]
    resources = [
      "*",
    ]
  }
}



