#!/usr/bin/env bash

set -Eeuo pipefail


# ============================================================
# APP Name
# Frontend Setup Script
#
# Sets up:
#
#   - React
#   - React DOM
#   - TypeScript
#   - SCSS / Sass
#   - Vite React plugin
#   - TypeScript configuration
#   - SCSS structure
#   - React example component
#   - Blade template
#
# This script is intended for DEVELOPMENT setup.
#
# Environment permissions are controlled by:
#
#   scripts/environmentGuard.sh
# ============================================================


# ------------------------------------------------------------
# Find scripts directory
# ------------------------------------------------------------

SCRIPT_DIR="$(
    cd "$(dirname "${BASH_SOURCE[0]}")"
    pwd
)"


# ------------------------------------------------------------
# Find project root
#
# This script should live at:
#
#   PROJECT_ROOT/scripts/setup-frontend.sh
# ------------------------------------------------------------

PROJECT_ROOT="$(
    cd "$SCRIPT_DIR/.."
    pwd
)"


# ------------------------------------------------------------
# Move to project root
# ------------------------------------------------------------

cd "$PROJECT_ROOT"


# ------------------------------------------------------------
# Environment protection
#
# environmentGuard.sh will:
#
#   - read .env
#   - read APP_ENV
#   - identify this script as setup-frontend.sh
#   - allow it only in development
#
# If the environment is not allowed, execution stops here.
# ------------------------------------------------------------

source "$SCRIPT_DIR/environmentGuard.sh"


# ------------------------------------------------------------
# Verify this actually looks like a Laravel project
# ------------------------------------------------------------

if [[ ! -f "$PROJECT_ROOT/artisan" ]]; then

    echo "❌ ERROR: Laravel artisan file was not found."
    echo
    echo "Expected:"
    echo
    echo "  $PROJECT_ROOT/artisan"
    echo
    echo "Create/install the Laravel project before running this script."

    exit 1

fi


if [[ ! -f "$PROJECT_ROOT/package.json" ]]; then

    echo "❌ ERROR: package.json was not found."
    echo
    echo "Expected:"
    echo
    echo "  $PROJECT_ROOT/package.json"

    exit 1

fi


echo
echo "============================================================"
echo "  Frontend Setup"
echo "============================================================"
echo


# ------------------------------------------------------------
# Install React runtime packages
# ------------------------------------------------------------

echo "📦 Installing React..."

npm install \
    react \
    react-dom


# ------------------------------------------------------------
# Install frontend development dependencies
# ------------------------------------------------------------

echo
echo "📦 Installing TypeScript, React types, Vite React, and Sass..."

npm install --save-dev \
    typescript \
    @types/react \
    @types/react-dom \
    @vitejs/plugin-react \
    sass


# ------------------------------------------------------------
# Add useful NPM scripts
# ------------------------------------------------------------

echo
echo "⚙️ Configuring NPM scripts..."

npm pkg set scripts.dev="vite"

npm pkg set scripts.build="vite build"

npm pkg set scripts.typecheck="tsc --noEmit"


# ------------------------------------------------------------
# Create frontend directories
# ------------------------------------------------------------

echo
echo "📁 Creating frontend directories..."

mkdir -p \
    resources/js/components \
    resources/scss \
    resources/views

# ------------------------------------------------------------
# Remove Laravel's default Vite configuration
#
# A fresh Laravel installation may create:
#
#   vite.config.js
#
# This template uses:
#
#   vite.config.ts
#
# Remove the default JavaScript/MJS versions so Vite does not
# have multiple competing configuration files.
# ------------------------------------------------------------

echo
echo "🧹 Removing default Laravel Vite configuration..."

rm -f \
    "$PROJECT_ROOT/vite.config.js" \
    "$PROJECT_ROOT/vite.config.mjs"


# ------------------------------------------------------------
# Create Vite configuration
# ------------------------------------------------------------

echo
echo "⚙️ Creating vite.config.ts..."

cat > vite.config.ts <<'EOF'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [

        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.tsx',
            ],

            refresh: true,
        }),

        react(),

    ],
});
EOF


# ------------------------------------------------------------
# Create TypeScript configuration
# ------------------------------------------------------------

echo "⚙️ Creating tsconfig.json..."

cat > tsconfig.json <<'EOF'
{
    "compilerOptions": {
        "target": "ES2022",
        "useDefineForClassFields": true,

        "lib": [
            "ES2022",
            "DOM",
            "DOM.Iterable"
        ],

        "allowJs": false,
        "skipLibCheck": true,

        "esModuleInterop": true,
        "allowSyntheticDefaultImports": true,

        "strict": true,

        "forceConsistentCasingInFileNames": true,

        "module": "ESNext",
        "moduleResolution": "Bundler",

        "resolveJsonModule": true,

        "isolatedModules": true,

        "noEmit": true,

        "jsx": "react-jsx"
    },

    "include": [
        "resources/js/**/*.ts",
        "resources/js/**/*.tsx"
    ]
}
EOF


# ------------------------------------------------------------
# Create main SCSS file
# ------------------------------------------------------------

echo "🎨 Creating resources/scss/app.scss..."

cat > resources/scss/app.scss <<'EOF'

// ============================================================
// Global Variables
// ============================================================

$background: #f5f5f5;
$text: #202020;
$accent: #3457d5;


// ============================================================
// Basic Reset
// ============================================================

* {
    box-sizing: border-box;
}


// ============================================================
// Page
// ============================================================

body {
    margin: 0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background: $background;

    color: $text;
}


// ============================================================
// Layout
// ============================================================

.container {
    width: min(1100px, 90%);

    margin-left: auto;
    margin-right: auto;
}


// ============================================================
// React Demo
// ============================================================

.react-demo {
    margin-top: 2rem;

    padding: 1.5rem;

    border: 1px solid #ccc;

    border-radius: 0.75rem;


    button {
        padding: 0.65rem 1rem;

        border: 0;

        border-radius: 0.4rem;

        cursor: pointer;

        background: $accent;

        color: white;
    }
}
EOF


# ------------------------------------------------------------
# Create React demonstration component
# ------------------------------------------------------------

echo "⚛️ Creating ReactDemo.tsx..."

cat > resources/js/components/ReactDemo.tsx <<'EOF'
import { useState } from 'react';


export default function ReactDemo() {

    const [count, setCount] = useState(0);


    return (

        <section className="react-demo">

            <h2>
                React is working
            </h2>


            <p>
                This component is being rendered by React
                inside a Laravel Blade page.
            </p>


            <button
                type="button"
                onClick={() => setCount((value) => value + 1)}
            >

                Clicked {count} times

            </button>

        </section>

    );
}
EOF


# ------------------------------------------------------------
# Create React entry point
# ------------------------------------------------------------

echo "⚛️ Creating resources/js/app.tsx..."

cat > resources/js/app.tsx <<'EOF'
import React from 'react';

import { createRoot } from 'react-dom/client';

import ReactDemo from './components/ReactDemo';


const demoElement = document.getElementById('react-demo');


if (demoElement) {

    createRoot(demoElement).render(

        <React.StrictMode>

            <ReactDemo />

        </React.StrictMode>

    );

}
EOF


# ------------------------------------------------------------
# Create reusable Blade template
# ------------------------------------------------------------

echo "📄 Creating bladeTemplate.blade.php..."

cat > resources/views/bladeTemplate.blade.php <<'EOF'
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>
        @yield('title', config('app.name'))
    </title>


    @viteReactRefresh


    @vite([
        'resources/scss/app.scss',
        'resources/js/app.tsx'
    ])

</head>


<body>


    <header>

        <div class="container">

            <h1>
                {{ config('app.name') }}
            </h1>

        </div>

    </header>


    <main class="container">


        @yield('content')


        {{--
            Example React mount point.

            React will find this element from:

                resources/js/app.tsx

            and mount ReactDemo into it.
        --}}

        <div id="react-demo"></div>


    </main>


</body>

</html>
EOF


# ------------------------------------------------------------
# Create basic home page
# ------------------------------------------------------------

echo "📄 Creating home.blade.php..."

cat > resources/views/home.blade.php <<'EOF'
@extends('bladeTemplate')


@section('title', "Michael's Tech Repair")


@section('content')


    <section>

        <h2>
            Local Computer & Technology Help
        </h2>


        <p>
            Computer repair, home technology help,
            device troubleshooting, PC builds,
            websites, cloud services, and more.
        </p>

    </section>


@endsection
EOF


# ------------------------------------------------------------
# Do NOT automatically modify routes/web.php
#
# We keep routing separate so this script cannot accidentally
# overwrite existing Laravel routes.
# ------------------------------------------------------------

echo
echo "ℹ️ The Blade files were created."
echo
echo "Add this route to routes/web.php if needed:"
echo
echo "    Route::view('/', 'home');"


# ------------------------------------------------------------
# Verify TypeScript configuration
# ------------------------------------------------------------

echo
echo "🔎 Running TypeScript check..."

npm run typecheck


# ------------------------------------------------------------
# Test production frontend build
# ------------------------------------------------------------

echo
echo "🏗️ Testing production frontend build..."

npm run build


# ------------------------------------------------------------
# Complete
# ------------------------------------------------------------

echo
echo "============================================================"
echo "✅ Frontend setup complete!"
echo "============================================================"
echo
echo "Installed:"
echo
echo "  React"
echo "  React DOM"
echo "  TypeScript"
echo "  React TypeScript definitions"
echo "  Vite React plugin"
echo "  Sass / SCSS"
echo
echo "Created:"
echo
echo "  vite.config.ts"
echo "  tsconfig.json"
echo "  resources/scss/app.scss"
echo "  resources/js/app.tsx"
echo "  resources/js/components/ReactDemo.tsx"
echo "  resources/views/bladeTemplate.blade.php"
echo "  resources/views/home.blade.php"
echo
echo "Development commands:"
echo
echo "  php artisan serve"
echo
echo "  npm run dev"
echo
echo "TypeScript check:"
echo
echo "  npm run typecheck"
echo
echo "Production frontend build:"
echo
echo "  npm run build"
echo
