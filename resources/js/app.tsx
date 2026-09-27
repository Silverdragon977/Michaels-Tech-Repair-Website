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
