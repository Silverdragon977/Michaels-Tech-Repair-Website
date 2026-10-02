@include('serviceTemplate', [

    'title' => 'Device Troubleshooting',

    'eyebrow' => 'Technical Support',

    'description' =>
        'General troubleshooting for technology that is not behaving as expected, including connection failures, configuration problems, and difficult-to-explain technical issues.',

    'meta' =>
        'Diagnosis • Connectivity • Configuration • Technical Support',

    'problems' => [

        [
            'title' => 'Devices Not Connecting',
            'description' =>
                'Troubleshooting devices that cannot connect to computers, networks, or other equipment.',
        ],

        [
            'title' => 'Unexpected Errors',
            'description' =>
                'Investigating unexplained error messages, freezing, and inconsistent behavior.',
        ],

        [
            'title' => 'Software Configuration',
            'description' =>
                'Helping applications and devices work together with the correct settings.',
        ],

        [
            'title' => 'Driver Problems',
            'description' =>
                'Identifying missing, outdated, or incompatible drivers.',
        ],

        [
            'title' => 'Performance Problems',
            'description' =>
                'Investigating slow or unreliable behavior in supported electronic devices.',
        ],

        [
            'title' => 'Unusual Technical Issues',
            'description' =>
                'Helping determine the cause of problems that do not fit neatly into another service category.',
        ],

    ],

    'included' => [

        'Initial problem assessment',
        'Device compatibility checks',
        'Connection troubleshooting',
        'Driver and software configuration',
        'System setting review',
        'Basic hardware diagnostics',
        'Troubleshooting recommendations',
        'Repair or replacement guidance',

    ],

    'imageLabel' => 'Device Troubleshooting Image',

    'process' => [

        [
            'title' => 'Explain the Problem',
            'description' =>
                'Describe what happens, when it started, and anything you have already attempted.',
        ],

        [
            'title' => 'Investigate',
            'description' =>
                'I review the symptoms and attempt to identify the underlying cause.',
        ],

        [
            'title' => 'Discuss Solutions',
            'description' =>
                'I explain the available options and any limitations before proceeding.',
        ],

        [
            'title' => 'Test the Result',
            'description' =>
                'We verify whether the original problem has been resolved.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Initial Troubleshooting',
            'price' => 'TBD',
        ],

        [
            'name' => 'Extended Diagnosis',
            'price' => 'TBD',
        ],

        [
            'name' => 'Remote Support',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'What if I do not know what is wrong?',
            'answer' =>
                'That is completely fine. You only need to describe the symptoms and what you were trying to do.',
        ],

        [
            'question' => 'Do you troubleshoot devices other than computers?',
            'answer' =>
                'Yes, depending on the device and the type of problem. Contact me with the model and a description of the issue.',
        ],

        [
            'question' => 'Can you help remotely?',
            'answer' =>
                'Some software and configuration issues can be handled remotely. Physical hardware problems generally require access to the device.',
        ],

    ],

    'ctaTitle' => 'Something Technical Not Working?',

    'ctaText' =>
        'You do not need to diagnose the problem yourself. Tell me what is happening and I can help identify the next step.',

])