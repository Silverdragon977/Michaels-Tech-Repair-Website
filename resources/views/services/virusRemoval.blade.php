@include('serviceTemplate', [

    'title' => 'Virus & Malware Removal',

    'eyebrow' => 'Computer Security',

    'description' =>
        'Help identifying and removing viruses, malware, unwanted software, browser hijackers, and other common computer security problems.',

    'meta' =>
        'Malware • Viruses • Browser Security • System Cleanup',

    'problems' => [

        [
            'title' => 'Viruses & Malware',
            'description' =>
                'Suspicious software, infected files, unexpected behavior, and potential malware infections.',
        ],

        [
            'title' => 'Browser Hijacking',
            'description' =>
                'Unwanted redirects, changed search engines, unfamiliar extensions, and suspicious notifications.',
        ],

        [
            'title' => 'Fake Security Warnings',
            'description' =>
                'Persistent pop-ups claiming your computer is infected or demanding immediate payment.',
        ],

        [
            'title' => 'Unwanted Programs',
            'description' =>
                'Removing unnecessary applications, bundled software, and potentially unwanted programs.',
        ],

        [
            'title' => 'Suspicious Computer Activity',
            'description' =>
                'Investigating unexpected processes, unusual resource usage, and unfamiliar applications.',
        ],

        [
            'title' => 'Security Configuration',
            'description' =>
                'Reviewing common security settings and helping reduce future exposure to threats.',
        ],

    ],

    'included' => [

        'Initial security assessment',
        'Malware scanning',
        'Virus and unwanted software removal',
        'Browser extension review',
        'Startup application inspection',
        'Security software configuration',
        'Operating system security updates',
        'Recommendations for safer everyday use',

    ],

    'imageLabel' => 'Computer Security Image',

    'process' => [

        [
            'title' => 'Describe the Symptoms',
            'description' =>
                'Tell me what happened, what warnings appeared, and whether suspicious links or files were opened.',
        ],

        [
            'title' => 'Security Assessment',
            'description' =>
                'I inspect the computer for suspicious applications, settings, and potential infections.',
        ],

        [
            'title' => 'Cleanup',
            'description' =>
                'I explain the recommended cleanup options and proceed with approved work.',
        ],

        [
            'title' => 'Review & Prevention',
            'description' =>
                'I check for remaining symptoms and explain practical steps to help prevent future problems.',
        ],

    ],

    'pricing' => [

        [
            'name' => 'Security Assessment',
            'price' => 'TBD',
        ],

        [
            'name' => 'Malware Removal',
            'price' => 'TBD',
        ],

        [
            'name' => 'Extended Cleanup',
            'price' => 'TBD',
        ],

    ],

    'faq' => [

        [
            'question' => 'Does a pop-up saying I have a virus mean my computer is infected?',
            'answer' =>
                'Not necessarily. Some warnings are fraudulent browser advertisements. I can help determine what is happening.',
        ],

        [
            'question' => 'Will removing malware delete my personal files?',
            'answer' =>
                'I aim to preserve personal data, but some infections may require more extensive recovery or a system reinstall. I will discuss the risks before proceeding.',
        ],

        [
            'question' => 'Can you guarantee every infection will be removed?',
            'answer' =>
                'No cleanup can guarantee that every threat has been eliminated. For serious compromises, a clean reinstall may be recommended.',
        ],

    ],

    'ctaTitle' => 'Concerned About a Computer Infection?',

    'ctaText' =>
        'Describe the symptoms and I can help determine whether your computer needs a security assessment or cleanup.',

])