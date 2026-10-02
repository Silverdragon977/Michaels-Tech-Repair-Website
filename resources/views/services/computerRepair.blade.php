{{-- Computer Repair Service Blade --}}
@include('serviceTemplate', [

    'title' => 'Computer Repair & Troubleshooting',

    'eyebrow' => 'Computer Repair',

    'description' =>
        'Help with slow computers, crashes, hardware failures, software problems, upgrades, and general troubleshooting.',

    'meta' =>
        'Desktop • Laptop • Hardware • Software',

    'problems' => [

        [
            'title' => 'Slow Computer',
            'description' =>
                'Troubleshooting startup delays, sluggish performance, and slow everyday use.',
        ],

        [
            'title' => 'Crashes & Freezing',
            'description' =>
                'Diagnosing freezes, blue screens, application crashes, and unstable systems.',
        ],

        [
            'title' => 'Hardware Problems',
            'description' =>
                'Identifying failing components and practical repair or replacement options.',
        ],

        [
            'title' => 'Software Problems',
            'description' =>
                'Help with broken applications, driver issues, installation problems, and configuration.',
        ],

        [
            'title' => 'Malware & Viruses',
            'description' =>
                'Removing unwanted software and helping secure the computer afterward.',
        ],

        [
            'title' => 'Upgrades',
            'description' =>
                'Storage, RAM, batteries, and other practical computer upgrades.',
        ],

    ],

    'included' => [

        'Hardware troubleshooting',
        'Software troubleshooting',
        'Driver installation',
        'Malware cleanup',
        'Operating system setup',
        'Storage upgrades',
        'Memory upgrades',
        'Laptop battery replacement',

    ],

    'imageLabel' =>
        'Computer Repair Image',

    'process' => [

        [
            'title' => 'Describe the Problem',
            'description' =>
                'Tell me what the computer is doing and when the problem started.',
        ],

        [
            'title' => 'Diagnosis',
            'description' =>
                'I inspect the computer and determine the likely cause.',
        ],

        [
            'title' => 'Review Options',
            'description' =>
                'I explain the available repair options before work continues.',
        ],

        [
            'title' => 'Repair & Testing',
            'description' =>
                'The repair is completed and the system is tested afterward.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Diagnosis',
            'price' => 'TBD',
        ],

        [
            'name' => 'Software Repair',
            'price' => 'TBD',
        ],

        [
            'name' => 'Hardware Installation',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'Do I need to know what is wrong first?',
            'answer' =>
                'No. Just describe what the computer is doing and I can start troubleshooting from there.',
        ],

        [
            'question' => 'Do you work on laptops and desktops?',
            'answer' =>
                'Yes. I can troubleshoot both laptop and desktop computers.',
        ],

        [
            'question' => 'Can I bring the computer to you?',
            'answer' =>
                'Yes. Drop-off can be arranged by appointment.',
        ],

    ],

    'ctaTitle' =>
        'Need Help With Your Computer?',

    'ctaText' =>
        'Tell me what the computer is doing and I can help determine the next step.',

])
