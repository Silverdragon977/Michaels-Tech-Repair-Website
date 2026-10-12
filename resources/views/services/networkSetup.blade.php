{{-- resources/views/services/networkSetup.blade.php --}}
@include('serviceTemplate', [

    'title' => 'Home & Small Business Networking',

    'eyebrow' => 'Networking',

    'description' =>
        'Network installation, configuration, and troubleshooting for homes, connected devices, and small business environments.',

    'meta' =>
        'Wi-Fi • Routers • Ethernet • Network Security',

    'problems' => [

        [
            'title' => 'Poor Wi-Fi Coverage',
            'description' =>
                'Investigating wireless dead zones, weak signals, and inconsistent coverage.',
        ],

        [
            'title' => 'Unstable Connections',
            'description' =>
                'Troubleshooting devices that frequently disconnect or experience unreliable connectivity.',
        ],

        [
            'title' => 'Router Configuration',
            'description' =>
                'Setting up and configuring supported routers, access points, and network equipment.',
        ],

        [
            'title' => 'Wired Networking',
            'description' =>
                'Planning and configuring Ethernet connections and compatible network switches.',
        ],

        [
            'title' => 'Network Segmentation',
            'description' =>
                'Advanced VLAN and network separation configuration for compatible equipment.',
        ],

        [
            'title' => 'Network Security',
            'description' =>
                'Reviewing wireless security, firewall rules, and practical network configuration improvements.',
        ],
        [
            'title' => 'Custom Length Network Cables',
            'description' =>
                'Creating custom length Ethernet cables (RJ-45)to fit your network setup neatly and efficiently.',
        ]

    ],

    'imageLabel' => 'Networking Image',

    'process' => [

        [
            'title' => 'Review Your Network',
            'description' =>
                'We discuss your internet connection, existing equipment, and the problems you are experiencing.',
        ],

        [
            'title' => 'Assess the Setup',
            'description' =>
                'I inspect the relevant network configuration and identify possible improvements.',
        ],

        [
            'title' => 'Configure Equipment',
            'description' =>
                'I implement the approved changes and configure compatible network hardware.',
        ],

        [
            'title' => 'Test Connectivity',
            'description' =>
                'We verify connectivity, coverage, and the relevant network features.',
        ],
        

    ],
    'pricing' => [
        'type' => 'network-cable',
    
        'service_fee' => 4.00,
    
        'price_per_foot' => 0.30,
    
        'max_feet' => 50,
    ],


    'faq' => [

        [
            'question' => 'Can you help with weak Wi-Fi in certain rooms?',
            'answer' =>
                'Yes. I can review coverage and recommend suitable placement, configuration changes, or additional equipment.',
        ],

        [
            'question' => 'Do you configure advanced networks?',
            'answer' =>
                'Yes. Depending on the equipment, I can help with VLANs, access points, firewall configuration, and network segmentation.',
        ],

        [
            'question' => 'Do I need to buy a new router?',
            'answer' =>
                'Not necessarily. I can review your existing equipment before recommending additional hardware.',
        ],
        [
            'question' => 'Can you create custom length network cables?',
            'answer' =>
                'Yes. I can create Ethernet cables (RJ-45) to the exact length needed for your network setup. I can do this on-site to ensure a perfect fit. Additionally, I have lots of cable in stock and will do 50ft + orders as needed.',
        ]

    ],

    'ctaTitle' => 'Need Help With Your Network?',

    'ctaText' =>
        'Tell me about your current equipment, connection problems, and what you want your network to accomplish.',

])
