application_name = "delivery"

domains = [
  "delivery.staging.nift.london"
]

repository_branch = "staging"
environment       = "staging"

env_terraform_backend_config = {
  bucket = "tfstate-390716156516"
  key    = "staging-infra.tfstate"
  region = "eu-west-2"
}
codestar_connection = "arn:aws:codestar-connections:eu-west-2:390716156516:connection/0e8e80aa-7e1e-45bb-bed4-b5d1c159f9ec"

