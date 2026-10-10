@include('serviceTemplate', [

    'title' => 'Virus & Malware Removal',

    'eyebrow' => 'Computer Security',

    'description' =>
        'Protect your computer from viruses, malware, scams, and unwanted software. We help identify and remove harmful  programs, resolve suspicious browser behavior, and check your computer\'s security to help prevent future infections.',

    'problems' => [

        [
            'title' => 'Viruses & Malware',
            'description' =>
                'Suspicious software, infected files, unexpected behavior, and potential malware infections.',
        ],

        [
            'title' => 'Browser Problems & Hijacking',
            'description' =>
                ' Unwanted redirects, changed search engines, unfamiliar extensions, and suspicious notifications.',
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
        [
            'title' => 'Help securing your computer',
            'description' =>
                'Assistance with configuring security settings, enableing 2FA,',
        ],
        [
            'title' => 'Security Checks & Protection',
            'description' =>
                'Reviewing antivirus protection, firewall settings, and security updates to help keep your computer protected.',
        ]

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
                'I will scan and inspect the computer for suspicious applications, settings, and potential infections.',
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


    'faq' => [
        [
            'question' => 'How do I know if my computer has a virus?',
            'answer' => 'Common signs include unexpected pop-ups, unfamiliar programs, browser redirects, and unusual computer behavior. However, these symptoms do not always indicate an infection, so further investigation may be needed.',
        ],
        [
            'question' => 'Does a pop-up saying I have a virus mean my computer is infected?',
            'answer' => 'Not necessarily. Some websites display fake security warnings designed to trick you into downloading software, calling fraudulent support numbers, or making payments. We can help determine whether the warning is legitimate.',
        ],
        [
            'question' => 'Will removing malware delete my personal files?',
            'answer' => 'Most common infections can be removed without affecting your personal files. However, severe infections may require deleting infected files or reinstalling the operating system. We will discuss potential data loss and backup options before proceeding.',
        ],
        [
            'question' => 'Can you guarantee every infection will be removed?',
            'answer' => 'No malware removal process can guarantee that every threat has been eliminated. While many infections can be successfully removed, serious or persistent infections may require a clean operating system installation.',
        ],
        [
            'question' => 'Can you help prevent future infections?',
            'answer' => 'Yes. We can review your antivirus protection, firewall settings, browser security, and system updates. We can also provide guidance on recognizing suspicious downloads, websites, and online scams.',
        ],
        [
            'question' => 'Can virus removal be performed remotely?',
            'answer' => 'Many common malware infections, browser problems, and unwanted programs can be addressed remotely. More serious infections or computers that cannot operate normally may require an in-person examination.',
        ],
        [
            'question' => 'What if I clicked a suspicious link or gave a scammer access to my computer?',
            'answer' => 'We can help check for unwanted software, investigate suspicious activity, and remove unauthorized remote-access programs. We can also guide you through securing affected accounts and changing compromised passwords.',
        ],
    ],

    'ctaTitle' => 'Concerned About a Computer Infection?',

    'ctaText' =>
        'Describe the symptoms and I can help determine whether your computer needs a security assessment or cleanup.',

])