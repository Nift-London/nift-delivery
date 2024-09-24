variable "application_name" {
  type = string
}

variable "domains" {
  type = set(string)
}

variable "modules_to_deploy" {
  type = set(string)
}

variable "environment" {
  type = string
}

variable "backend_image" {
  type    = string
  default = "nginx:latest"
}

variable "nginx_image" {
  type    = string
  default = "nginx:latest"
}

variable "repository_branch" {
  type = string
}
variable "repository_name" {
  type = string
}

variable "env_terraform_backend_config" {
  type = object({
    bucket  = string
    key     = string
    region  = string
    profile = optional(string)
  })
}
variable "codestar_connection" {
  type = string
}
