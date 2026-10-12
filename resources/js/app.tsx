import React from 'react';

import { createRoot } from 'react-dom/client';

import ReactDemo from './components/ReactDemo';
import { initContactPhone } from './components/contactPhone';
import { initContactPrivacy } from './components/contact-privacy';
import { initNetworkCablePricing, initNetworkPricing } from './components/NetworkCablePricing';


const demoElement = document.getElementById('react-demo');


if (demoElement) {

    createRoot(demoElement).render(

        <React.StrictMode>

            <ReactDemo />

        </React.StrictMode>

    );

}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initContactPhone();
        initContactPrivacy();
        initNetworkPricing();
    }  );
} else {
    initContactPhone();
    initContactPrivacy();
    initNetworkPricing();
}
