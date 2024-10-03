data "aws_secretsmanager_secret" "composer-auth-token" {
  name = "${var.environment}/composer-auth-token"
}

data "aws_secretsmanager_secret_version" "composer-auth-token-version" {
  secret_id     = data.aws_secretsmanager_secret.composer-auth-token.id
}

module "deployment" {
  source     = "registry.terraform.io/l4gdev/codedeploy-ecr/aws"
  version    = "0.2.2"
  subnet_ids = local.vpc.private_subnets
  vpc_id     = local.vpc.vpc_id

  repository = {
    branch = var.repository_branch
    name   = var.repository_name
  }

  resource_to_deploy = var.modules_to_deploy
  region             = data.aws_region.current.name
  tfstate_bucket     = var.env_terraform_backend_config.bucket

  build_envs = {
    IMAGE_REPO_URL  = aws_ecr_repository.reg.repository_url
#    COMPOSER_AUTH_TOKEN = jsondecode(data.aws_secretsmanager_secret_version.composer-auth-token-version.secret_string)["secret"]
    DOCKER_BUILDKIT = "1"
  }

  build_configuration = {
    build_timeout      = "300"
    compute_type       = "BUILD_GENERAL1_SMALL"
    encrypted_artifact = true
    image              = "aws/codebuild/amazonlinux2-x86_64-standard:5.0"
    terraform_version  = "1.9.7"
  }
  custom_build_spec = data.local_file.docker_build_buildspec.content
  application_name  = var.application_name

  codestar_connection_arn   = var.codestar_connection
  environment_name          = var.environment
  pipeline_artifacts_bucket = "build-artefacts-${data.aws_caller_identity.current.account_id}"

}


data "local_file" "docker_build_buildspec" {
  filename = "docker-build.yml"
}
