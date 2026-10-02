@include('serviceTemplate', [

    'title' => 'Home Technology Setup',

    'eyebrow' => 'Home Technology',

    'description' =>
        'Help installing, connecting, and configuring everyday household technology, from televisions and printers to computers and smart devices.',

    'meta' =>
        'TVs • Printers • Smart Devices • Home Electronics',

    'problems' => [

        [
            'title' => 'New Device Setup',
            'description' =>
                'Getting new household technology connected, configured, and ready for everyday use.',
        ],

        [
            'title' => 'TV & Streaming Setup',
            'description' =>
                'Connecting televisions, streaming devices, applications, and related equipment.',
        ],

        [
            'title' => 'Printer Setup',
            'description' =>
                'Installing printers, configuring connections, and resolving common setup issues.',
        ],

        [
            'title' => 'Smart Home Devices',
            'description' =>
                'Help connecting supported smart plugs, cameras, speakers, and other connected devices.',
        ],

        [
            'title' => 'Computer Peripherals',
            'description' =>
                'Setting up monitors, keyboards, mice, webcams, speakers, and accessories.',
        ],

        [
            'title' => 'Device Connections',
            'description' =>
                'Troubleshooting common HDMI, Bluetooth, USB, and wireless connection issues.',
        ],

    ],

    'included' => [

        'New device installation and configuration',
        'TV and streaming device setup',
        'Printer and scanner setup',
        'Computer accessory installation',
        'Supported smart home device setup',
        'Bluetooth and wireless pairing',
        'Cable and connection troubleshooting',
        'Basic instruction on using installed equipment',

    ],

    'imageLabel' => 'Home Technology Image',

    'process' => [

        [
            'title' => 'Describe Your Setup',
            'description' =>
                'Tell me which devices you have and what you want them to do.',
        ],

        [
            'title' => 'Review Requirements',
            'description' =>
                'I check compatibility, connection requirements, and any additional equipment needed.',
        ],

        [
            'title' => 'Installation',
            'description' =>
                'I connect and configure the devices according to the agreed setup.',
        ],

        [
            'title' => 'Demonstration',
            'description' =>
                'We test the equipment together and I explain how to use the important features.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Single Device Setup',
            'price' => 'TBD',
        ],

        [
            'name' => 'Multiple Device Setup',
            'price' => 'TBD',
        ],

        [
            'name' => 'On-Site Assistance',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'Can you come to my home?',
            'answer' =>
                'On-site appointments may be available depending on location, scheduling, and the type of work required.',
        ],

        [
            'question' => 'Can you help if I do not understand the equipment?',
            'answer' =>
                'Absolutely. You can describe what you want to accomplish without needing to know the technical terminology.',
        ],

        [
            'question' => 'Do I need to purchase equipment beforehand?',
            'answer' =>
                'Not necessarily. I can help review compatibility and requirements before you purchase equipment.',
        ],

    ],

    'ctaTitle' => 'Need Help Setting Something Up?',

    'ctaText' =>
        'Tell me which devices you have and what you want to connect. We can work out the setup from there.',

])