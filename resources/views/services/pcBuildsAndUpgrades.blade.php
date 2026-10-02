@include('serviceTemplate', [

    'title' => 'Custom PC Builds & Upgrades',

    'eyebrow' => 'Computer Hardware',

    'description' =>
        'Custom desktop computer builds, hardware upgrades, component selection, and system configuration based on your needs and budget.',

    'meta' =>
        'Custom PCs • Upgrades • Components • Performance',

    'problems' => [

        [
            'title' => 'Choosing PC Components',
            'description' =>
                'Selecting compatible parts for gaming, work, productivity, or general computing.',
        ],

        [
            'title' => 'Building a New Computer',
            'description' =>
                'Assembling a custom computer based on your intended use and budget.',
        ],

        [
            'title' => 'Slow Existing Hardware',
            'description' =>
                'Identifying practical upgrades for older or underperforming computers.',
        ],

        [
            'title' => 'Compatibility Questions',
            'description' =>
                'Checking whether components will work with an existing or planned system.',
        ],

        [
            'title' => 'Storage & Memory Upgrades',
            'description' =>
                'Installing compatible SSDs, hard drives, and system memory.',
        ],

        [
            'title' => 'System Configuration',
            'description' =>
                'Operating system installation, drivers, firmware review, and initial setup.',
        ],

    ],

    'included' => [

        'Build planning and component recommendations',
        'Hardware compatibility checks',
        'Custom desktop assembly',
        'RAM and storage upgrades',
        'Graphics card installation',
        'Cooling and airflow configuration',
        'Operating system and driver setup',
        'Initial system testing',

    ],

    'imageLabel' => 'Custom PC Build Image',

    'process' => [

        [
            'title' => 'Discuss Your Needs',
            'description' =>
                'Tell me what you use your computer for and your approximate budget.',
        ],

        [
            'title' => 'Select Components',
            'description' =>
                'I prepare compatible hardware recommendations and review the options with you.',
        ],

        [
            'title' => 'Build or Upgrade',
            'description' =>
                'I assemble the computer or install the agreed upgrades.',
        ],

        [
            'title' => 'Configure & Test',
            'description' =>
                'The computer is configured and tested before delivery or pickup.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Build Consultation',
            'price' => 'TBD',
        ],

        [
            'name' => 'Custom PC Assembly',
            'price' => 'TBD',
        ],

        [
            'name' => 'Hardware Upgrades',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'Can you help choose the parts?',
            'answer' =>
                'Yes. I can prepare component recommendations based on your budget, intended use, and preferences.',
        ],

        [
            'question' => 'Can I supply my own components?',
            'answer' =>
                'Yes, although I will need to review compatibility and condition before beginning assembly.',
        ],

        [
            'question' => 'Do you only build gaming computers?',
            'answer' =>
                'No. Custom computers can be configured for gaming, general productivity, creative work, or other requirements.',
        ],

    ],

    'ctaTitle' => 'Planning a New Computer or Upgrade?',

    'ctaText' =>
        'Tell me what you want your computer to do and your budget. I can help determine which hardware makes sense.',

])