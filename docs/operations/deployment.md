# Deployment

This document describes the deployment model for the project, including infrastructure components, environments, and the
deployment process. The application is hosted on **AWS Cloud**, leveraging managed services for scalability,
reliability, and cost efficiency.

---

## Infrastructure Overview

### AWS Services Used

- **Compute:**
    - Amazon ECS with Fargate for container orchestration
    - Lambda for serverless workloads
- **Networking:**
    - Application Load Balancer (ALB) for traffic routing
    - Virtual Private Cloud (VPC) for network isolation
- **Storage:**
    - Amazon S3 for static assets and backups
    - Amazon RDS (MySQL) for relational databases
- **Messaging:**
    - Amazon SQS for message queuing
    - Amazon SNS for notifications
- **Monitoring:**
    - Amazon CloudWatch for logs and metrics
    - AWS X-Ray for tracing
- **Security:**
    - AWS Identity and Access Management (IAM) for role-based permissions
    - AWS WAF for web application security

---

## Deployment Workflow

### 1. Code Commit and Build

- Developers push code changes to the `main` branch.
- **CI/CD Pipeline:** A GitHub Actions pipeline runs:
    1. Static analysis (PHPStan, ESLint)
    2. Unit and integration tests
    3. Build container images

### 2. Deployment to AWS

- **Staging Environment:**
    - Deployed automatically on successful builds from `main`.
    - AWS ECS service runs the application.
- **Production Environment:**
    - Manual approval step in CI/CD pipeline.
    - Uses blue/green deployment strategy for zero-downtime updates.

### 3. Monitoring and Scaling

- **Auto Scaling:**
    - ECS scales tasks based on CPU/memory utilization.
- **Error Monitoring:**
    - Alerts configured in CloudWatch and SNS.

---

## Environment Details

### Staging

- **Purpose:** Pre-production testing
- **Components:**
    - ECS cluster in a `staging` VPC
    - S3 bucket for staging assets
    - RDS instance for testing
    - Limited IAM permissions

### Production

- **Purpose:** Live application
- **Components:**
    - ECS cluster in a `production` VPC
    - S3 bucket for live assets
    - Highly available RDS instance (Multi-AZ)
    - Full IAM permissions with least privilege

---

## Deployment Diagram

_Attach an AWS Deployment Diagram_

---

## Tools and Automation

- **CI/CD Tools:**
    - GitHub Actions for pipelines
    - AWS CodeDeploy for blue/green deployments
- **Infrastructure as Code (IaC):**
    - Terraform for provisioning AWS resources
    - AWS CloudFormation for resource templates
- **Monitoring and Logs:**
    - CloudWatch dashboards for live metrics
    - Centralized log aggregation using CloudWatch Logs

---

## Future Enhancements

- Adopt AWS Elastic Kubernetes Service (EKS) for container orchestration.
- Implement cost optimization strategies using AWS Cost Explorer.
- Integrate AWS Backup for automated database and file backups.
