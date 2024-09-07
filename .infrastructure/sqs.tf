#module "sqs-subscription" {
#  source                    = "registry.terraform.io/l4gdev/sns-to-sqs-subscriber/aws//sqs-subscriber"
#  version                   = "0.1.3"
#  name                      = var.application_name
#  fifo                      = false
#  application_iam_role_name = module.dave.task_iam_role_name
#  environment               = var.environment
#  dlq = {
#    enable = true
#  }
#}
