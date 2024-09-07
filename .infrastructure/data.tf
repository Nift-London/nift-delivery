data "terraform_remote_state" "backend" {
  backend = "s3"
  config  = var.env_terraform_backend_config
}

data "aws_caller_identity" "current" {}
data "aws_region" "current" {}

locals {
  local_route53                              = data.terraform_remote_state.backend.outputs.local_route53
  vpc                                        = data.terraform_remote_state.backend.outputs.vpc
  ecs_cluster_name                           = data.terraform_remote_state.backend.outputs.ecs_cluster_name
  rds                                        = data.terraform_remote_state.backend.outputs.rds
  list_of_secrets_in_secrets_manager_to_load = [
    "${var.environment}/delivery/evermile"
  ]
  datadog = {
    DD_SERVICE           = var.application_name
    DD_ENV               = var.environment
    DD_VERSION           = "${var.environment}-${split(":", var.backend_image)[1]}"
    DD_TRACE_CLI_ENABLED = "true"
  }

  app_envs = {
    APP_ENV   = var.environment == "prod" ? "production" : "dev"

    APP_SECRET= "38046169249516244b956f73366bcc2e"
    APP_DEBUG = var.environment == "prod" ? "false" : "true"

    DATABASE_URL="mysql://admin:${local.rds.password}@mysql.${var.environment}.local:3306/delivery?charset=utf8mb4"

    # Remove this user and push this to secret manager
    MAIL_MAILER       = "smtp"
    MAIL_HOST         = "email-smtp.eu-west-2.amazonaws.com"
    MAIL_PORT         = "587"
    MAIL_USERNAME     = "AKIA5Y27HW2D2Z743Y43"
    MAIL_PASSWORD     = "BPHLi6XWORlYKAfWaOpZxLi9bMEYUJi0amZx3jJO6JO+"
    MAIL_ENCRYPTION   = "starttls"
    MAIL_FROM_ADDRESS = "no-reply@nift.london"
    MAIL_FROM_NAME    = "NIFT delivery"
  }

  full_app_envs = merge(
    local.datadog,
    local.app_envs,

  )
}

resource "aws_s3_bucket" "dave" {
  bucket = "${var.environment}-${var.application_name}-${data.aws_caller_identity.current.account_id}"
}
