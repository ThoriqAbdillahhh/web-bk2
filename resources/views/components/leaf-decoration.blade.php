@props(['class' => 'w-48 h-48'])

<svg {{ $attributes->merge(['class' => $class . ' pointer-events-none']) }} viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <filter id="blur-effect" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="3" />
        </filter>
    </defs>
    
    <!-- Daun Ungu -->
    <path d="M150 20C160 40 180 50 190 40C185 70 165 80 140 60C145 40 140 30 150 20Z" fill="#C4B5FD" filter="url(#blur-effect)" opacity="0.8"/>
    <path d="M180 60C190 80 210 90 220 80C215 110 195 120 170 100C175 80 170 70 180 60Z" fill="#C4B5FD" filter="url(#blur-effect)" opacity="0.6"/>
    
    <!-- Daun Hijau Limau -->
    <path d="M120 10C130 30 140 40 130 60C110 50 100 30 120 10Z" fill="#D9F99D" filter="url(#blur-effect)" opacity="0.9"/>
    <path d="M190 10C200 15 210 30 200 40C185 35 185 20 190 10Z" fill="#D9F99D" filter="url(#blur-effect)" opacity="0.7"/>
    
    <!-- Daun Oranye -->
    <path d="M170 110C180 120 200 120 210 110C210 130 190 140 170 130C165 120 165 115 170 110Z" fill="#FDBA74" filter="url(#blur-effect)" opacity="0.8"/>
    <path d="M130 80C140 90 150 100 140 110C120 100 120 90 130 80Z" fill="#FDBA74" filter="url(#blur-effect)" opacity="0.6"/>
</svg>