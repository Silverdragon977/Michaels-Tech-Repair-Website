@include('serviceTemplate', [

    'title' => 'Home Media Server Setup',

    'eyebrow' => 'Home Entertainment',

    'description' =>
        'Personal media server installation and configuration for organizing and streaming your own digital media throughout your home.',

    'meta' =>
        'Jellyfin • Plex • Streaming • Home Servers',

    'problems' => [

        [
            'title' => 'Scattered Media Files',
            'description' =>
                'Organizing an existing digital media collection into a more accessible library.',
        ],

        [
            'title' => 'Streaming Between Devices',
            'description' =>
                'Configuring supported devices to stream from a central home media server.',
        ],

        [
            'title' => 'Media Server Installation',
            'description' =>
                'Installing and configuring supported personal media server software.',
        ],

        [
            'title' => 'Playback Problems',
            'description' =>
                'Troubleshooting common compatibility, connection, and streaming performance issues.',
        ],

        [
            'title' => 'Storage Configuration',
            'description' =>
                'Planning appropriate storage for an existing digital media library.',
        ],

        [
            'title' => 'Remote Access',
            'description' =>
                'Reviewing supported and secure options for accessing a personal media server remotely.',
        ],

    ],

    'included' => [

        'Home media server consultation',
        'Jellyfin or Plex installation',
        'Media library configuration',
        'Storage and folder organization',
        'Client device setup',
        'Local network streaming configuration',
        'Playback troubleshooting',
        'Basic access and security configuration',

    ],

    'imageLabel' => 'Home Media Server Image',

    'process' => [

        [
            'title' => 'Review Your Equipment',
            'description' =>
                'We discuss your existing computers, storage, network, and playback devices.',
        ],

        [
            'title' => 'Plan the Server',
            'description' =>
                'I recommend suitable software, hardware, and configuration options.',
        ],

        [
            'title' => 'Install & Configure',
            'description' =>
                'I configure the approved server setup and connect supported devices.',
        ],

        [
            'title' => 'Test Playback',
            'description' =>
                'We test media access and playback across the intended devices.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Media Server Consultation',
            'price' => 'TBD',
        ],

        [
            'name' => 'Initial Server Setup',
            'price' => 'TBD',
        ],

        [
            'name' => 'Additional Configuration',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'Do I need to purchase a dedicated server?',
            'answer' =>
                'Not necessarily. Depending on your requirements, an existing compatible computer may be sufficient.',
        ],

        [
            'question' => 'Can I watch my media on multiple devices?',
            'answer' =>
                'Yes. Supported televisions, computers, phones, and streaming devices can connect to compatible media server software.',
        ],

        [
            'question' => 'Will you provide movies or television shows?',
            'answer' =>
                'No. This service is for configuring software and equipment to manage media you already have the rights to use.',
        ],

    ],

    'ctaTitle' => 'Interested in Your Own Media Server?',

    'ctaText' =>
        'Tell me about your existing media collection, equipment, and the devices you want to stream to.',

])