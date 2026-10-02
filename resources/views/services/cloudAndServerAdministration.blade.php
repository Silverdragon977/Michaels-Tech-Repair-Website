@include('serviceTemplate', [

    'title' => 'Cloud & Server Administration',

    'eyebrow' => 'Advanced IT Services',

    'description' =>
        'Linux server administration, cloud infrastructure, containerized applications, deployment automation, and DevOps support for personal projects and small business environments.',

    'meta' =>
        'Linux • Cloud Hosting • Docker • DevOps • CI/CD',

    'problems' => [

        [
            'title' => 'Server Deployment',
            'description' =>
                'Setting up and configuring Linux servers for websites, applications, and other supported workloads.',
        ],

        [
            'title' => 'Cloud Infrastructure',
            'description' =>
                'Assistance planning and configuring virtual private servers and supported cloud services.',
        ],

        [
            'title' => 'Docker & Containers',
            'description' =>
                'Containerizing supported applications and configuring Docker-based deployments.',
        ],

        [
            'title' => 'Deployment Automation',
            'description' =>
                'Improving repeatable deployment workflows with scripts and supported CI/CD tools.',
        ],

        [
            'title' => 'Server Security',
            'description' =>
                'Reviewing SSH access, firewall configuration, HTTPS, and common Linux security settings.',
        ],

        [
            'title' => 'Infrastructure Troubleshooting',
            'description' =>
                'Investigating service failures, deployment problems, application hosting issues, and configuration errors.',
        ],

    ],

    'included' => [

        'Linux server installation and configuration',
        'Virtual private server setup',
        'Docker and Docker Compose deployments',
        'Reverse proxy and HTTPS configuration',
        'SSH and firewall configuration',
        'Git-based deployment workflows',
        'CI/CD pipeline setup',
        'Server maintenance and troubleshooting',

    ],

    'imageLabel' => 'Cloud Infrastructure Image',

    'process' => [

        [
            'title' => 'Discuss Requirements',
            'description' =>
                'We review the application, workload, hosting requirements, and desired infrastructure.',
        ],

        [
            'title' => 'Plan the Environment',
            'description' =>
                'I outline an appropriate configuration, deployment approach, and expected resource requirements.',
        ],

        [
            'title' => 'Provision & Configure',
            'description' =>
                'I configure the approved infrastructure and implement the required deployment workflow.',
        ],

        [
            'title' => 'Validate & Document',
            'description' =>
                'We test the deployment and review relevant configuration, access, and maintenance procedures.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Infrastructure Consultation',
            'price' => 'TBD',
        ],

        [
            'name' => 'Server Provisioning',
            'price' => 'Custom Quote',
        ],

        [
            'name' => 'Deployment & Automation',
            'price' => 'Custom Quote',
        ],

    ],

    'faq' => [

        [
            'question' => 'What cloud platforms do you work with?',
            'answer' =>
                'I can discuss Linux-based VPS hosting and supported cloud infrastructure, including DigitalOcean and AWS-related projects. Platform compatibility and project scope are reviewed beforehand.',
        ],

        [
            'question' => 'Can you help deploy a Docker application?',
            'answer' =>
                'Yes. I can help with Docker configuration, containerized application deployment, and related hosting requirements.',
        ],

        [
            'question' => 'What does DevOps support include?',
            'answer' =>
                'Depending on the project, this may include deployment scripts, Git-based workflows, CI/CD pipelines, server configuration, and infrastructure automation.',
        ],

        [
            'question' => 'Do you provide ongoing server administration?',
            'answer' =>
                'Maintenance and administration arrangements can be discussed based on project requirements, scope, and availability.',
        ],

    ],

    'ctaTitle' => 'Planning a Server or Cloud Project?',

    'ctaText' =>
        'Describe your application, current infrastructure, or deployment requirements and I can help review the available options.',

])