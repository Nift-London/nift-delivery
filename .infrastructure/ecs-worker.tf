#module "delivery-worker" {
#  source  = "registry.terraform.io/l4gdev/ecs-service/aws"
#  version = "0.3.4"
#
#  application_config = {
#    name        = "${var.application_name}-worker"
#    environment = var.environment
#    cpu         = 0,
#    memory      = 1024,
#    image       = var.backend_image
#    environments_variables = merge(
#      local.full_app_envs,
#      { ENTRY_POINT = "worker" }
#    )
#  }
#  list_of_secrets_in_secrets_manager_to_load = local.list_of_secrets_in_secrets_manager_to_load
#
#  ecs_settings = {
#    ecs_launch_type  = "EC2",
#    ecs_cluster_name = local.ecs_cluster_name,
#    run_type         = "WORKER",
#    lang             = "PHP",
#  }
#
#  tags = {
#    Env     = var.environment
#    Service = var.application_name
#  }
#
#  service_policy = data.aws_iam_policy_document.app_policy.json
#  vpc_id         = local.vpc.vpc_id
#
#  deployment = {
#    first_deployment_desired_count = 1
#    minimum_healthy_percent        = 50
#    maximum_healthy_percent        = 200
#    enable_asg                     = false
#  }
#}
#
#
#
