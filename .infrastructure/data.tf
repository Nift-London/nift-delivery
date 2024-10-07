data "terraform_remote_state" "backend" {
  backend = "s3"
  config  = var.env_terraform_backend_config
}

resource "aws_ecr_repository" "reg" {
  name = "${var.environment}-${var.application_name}"
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
    APP_DEBUG = var.environment == "prod" ? "false" : "true"

    APP_SECRET= "38046169249516244b956f73366bcc2e"
    APP_URL="https://delivery.staging.nift.london"

    DATABASE_URL="mysql://admin:${local.rds.password}@mysql.${var.environment}.local:3306/delivery?charset=utf8mb4"
  }

  full_app_envs = merge(
    local.datadog,
    local.app_envs,

  )
}

resource "aws_s3_bucket" "delivery" {
  bucket = "${var.environment}-${var.application_name}-${data.aws_caller_identity.current.account_id}"
}