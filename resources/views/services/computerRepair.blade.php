{{-- Computer Repair Service Blade --}}
@include('serviceTemplate', [

    'title' => 'Computer Repair & Troubleshooting',

    'eyebrow' => 'Computer Repair',

    'description' =>
        'Are you having trouble with your computer or laptop? Here at Michael\'s Tech Repair, I can help identify your hardware problems and replace the broken or faulty parts, including screens, batteries, keyboards, and cooling fans. That way we can get your device back to optimal performance. Below are some of the common problems in this service. Please contact me for next steps.',

    'problems' => [

        [
            'title' => 'Slow Computer',
            'description' =>
                'Troubleshooting startup delays, sluggish performance, and slow everyday use.',
        ],
        [
            'title' => 'Power & Charging',
            'description' =>
                'Computers that won\'t start, faulty batteries, charging issues, and power failures',
        ],
        [
            'title' => 'Keyboard & Touchpad',
            'description' =>
                'Help with unresponsive or malfunctioning keyboards and touchpads, including driver and hardware issues.',
        ],
        [
            'title' => 'Storage & Boot Issues',
            'description' =>
                'Help with slow storage, boot errors, and inaccessible drives.',
        ],
        [
            'title' => 'Screen Problems',
            'description' =>
                'Cracked screens, flickering displays, dead pixels, and blank screens.',
        ],
        [
            'title' => 'Overheating, Fans & Cooling',
            'description' =>
                'Addressing overheating issues, loud fans, reseating CPU Coolers, and improving overall cooling performance.',
        ],
        [
            'title' => 'Crashes & Freezing',
            'description' =>
                'Diagnosing freezes, blue screens, application crashes, and unstable systems.',
        ],
        [
            'title' => 'Replacing Components',
            'description' =>
                'Replacing faulty or outdated hardware components in laptops and desktops.',
        ],
        [
            'title' => 'Hardware Problems',
            'description' =>
                'Identifying failing components and practical repair or replacement options.',
        ],


    ],

    'included' => [

        'Hardware troubleshooting',
        'Operating system troubleshooting',
        'Driver installation',
        'Operating system setup',
        'Speed optimization',

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
