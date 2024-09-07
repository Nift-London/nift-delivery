application_name = "dave"

domains = [
    "dave.nift.london"
]

repository_branch = "main"
environment       = "prod"

env_terraform_backend_config = {
    bucket = "tfstate-946703152775"
    key    = "prod-infra.tfstate"
    region = "eu-west-2"
}

codestar_connection = "arn:aws:codestar-connections:eu-west-2:946703152775:connection/32912209-3ce2-4333-88c4-0c53ad17b674"

