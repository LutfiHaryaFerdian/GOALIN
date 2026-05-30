@props(['class' => 'w-64 h-64'])

<svg class="{{ $class }}" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Shadow -->
    <ellipse cx="100" cy="180" rx="60" ry="10" fill="#EBEBEB"/>
    
    <!-- Body (Duo Green #58CC02) -->
    <path d="M50 120C50 70.2944 80 50 100 50C120 50 150 70.2944 150 120C150 160 120 170 100 170C80 170 50 160 50 120Z" fill="#58CC02"/>
    
    <!-- Belly (Light Green #A5ED43) -->
    <path d="M65 125C65 95 80 85 100 85C120 85 135 95 135 125C135 150 120 160 100 160C80 160 65 150 65 125Z" fill="#A5ED43" opacity="0.9"/>
    
    <!-- Belly Feathers (Chunky Chevron Style) -->
    <path d="M90 105L100 112L110 105" stroke="#49AD00" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M85 125L100 135L115 125" stroke="#49AD00" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M90 145L100 152L110 145" stroke="#49AD00" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>

    <!-- Left Ear/Tuft -->
    <path d="M50 75L40 45L75 60" fill="#58CC02"/>
    <!-- Right Ear/Tuft -->
    <path d="M150 75L160 45L125 60" fill="#58CC02"/>

    <!-- Left Eye Outer (White) -->
    <circle cx="75" cy="80" r="26" fill="white" stroke="#E5E5E5" stroke-width="2"/>
    <!-- Right Eye Outer (White) -->
    <circle cx="125" cy="80" r="26" fill="white" stroke="#E5E5E5" stroke-width="2"/>
    
    <!-- Left Eye Pupil (Ink #3C3C3C) -->
    <circle cx="77" cy="80" r="10" fill="#3C3C3C"/>
    <!-- Right Eye Pupil (Ink #3C3C3C) -->
    <circle cx="123" cy="80" r="10" fill="#3C3C3C"/>
    
    <!-- Eye Highlights (Cute Sparkle) -->
    <circle cx="74" cy="77" r="3" fill="white"/>
    <circle cx="120" cy="77" r="3" fill="white"/>

    <!-- Beak (Orange #FF9600) -->
    <path d="M100 90L92 105L108 105Z" fill="#FF9600" stroke="#FF9600" stroke-width="2" stroke-linejoin="round"/>
    
    <!-- Wings (Duo Green) -->
    <!-- Left Wing (waving) -->
    <path d="M52 110C35 105 20 85 25 75C30 65 45 85 52 100" fill="#49AD00" stroke="#58CC02" stroke-width="3"/>
    <!-- Right Wing (holding soccer ball) -->
    <path d="M148 115C160 120 175 125 170 135C165 145 152 130 148 120" fill="#49AD00" stroke="#58CC02" stroke-width="3"/>

    <!-- Headband (Sporty Accent - Blue #1CB0F6) -->
    <path d="M60 52C80 48 120 48 140 52L142 58C122 54 78 54 58 58Z" fill="#1CB0F6" stroke="#0C9BD9" stroke-width="2"/>
    <rect x="94" y="47" width="12" height="8" rx="2" fill="white" stroke="#0C9BD9" stroke-width="1.5"/>

    <!-- Soccer Ball in Right Wing area -->
    <g transform="translate(150, 125)">
        <circle cx="15" cy="15" r="15" fill="white" stroke="#3C3C3C" stroke-width="2.5"/>
        <!-- Pentagon patterns on ball -->
        <polygon points="15,7 21,12 19,18 11,18 9,12" fill="#3C3C3C"/>
        <!-- Line markings -->
        <line x1="15" y1="7" x2="15" y2="1" stroke="#3C3C3C" stroke-width="2"/>
        <line x1="21" y1="12" x2="27" y2="9" stroke="#3C3C3C" stroke-width="2"/>
        <line x1="19" y1="18" x2="24" y2="23" stroke="#3C3C3C" stroke-width="2"/>
        <line x1="11" y1="18" x2="6" y2="23" stroke="#3C3C3C" stroke-width="2"/>
        <line x1="9" y1="12" x2="3" y2="9" stroke="#3C3C3C" stroke-width="2"/>
    </g>

    <!-- Orange Feet -->
    <path d="M80 168C75 168 70 175 75 178C80 180 85 175 85 168Z" fill="#FF9600"/>
    <path d="M120 168C115 168 110 175 115 178C120 180 125 175 125 168Z" fill="#FF9600"/>
</svg>
