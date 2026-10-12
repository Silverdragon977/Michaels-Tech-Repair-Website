export function initNetworkPricing(): void {
    const container = document.getElementById(
        'network-cable-pricing'
    ) as HTMLDivElement | null;

    if (!container) {
        return;
    }

    const serviceFee = Number(container.dataset.serviceFee);
    const pricePerFoot = Number(container.dataset.pricePerFoot);
    const maxFeet = Number(container.dataset.maxFeet);

    if (
        Number.isNaN(serviceFee) ||
        Number.isNaN(pricePerFoot) ||
        Number.isNaN(maxFeet)
    ) {
        return;
    }

    container.innerHTML = `
        <div class="pricing-row">
            <span>
                Cable Length
            </span>

            <span>
                <strong id="network-length-display">1 ft 0 in</strong>
            </span>
        </div>

        <div class="pricing-row">

            <span>
                Feet
            </span>

            <span>
                <input
                    id="network-cable-feet"
                    type="range"
                    min="1"
                    max="${maxFeet}"
                    step="1"
                    value="1"
                >

                <input
                    id="network-cable-feet-number"
                    type="number"
                    min="1"
                    max="${maxFeet}"
                    step="1"
                    value="1"
                    aria-label="Cable length in feet"
                >
            </span>

        </div>

        <div class="pricing-row">

            <span>
                Inches
            </span>

            <span>
                <input
                    id="network-cable-inches"
                    type="range"
                    min="0"
                    max="11"
                    step="1"
                    value="0"
                    aria-label="Additional cable length in inches"
                >
            </span>

        </div>

        <div class="pricing-row">

            <span>
                Total Length
            </span>

            <span>
                <input
                    id="network-cable-total"
                    type="text"
                    value="1 ft 0 in"
                    readonly
                >
            </span>

        </div>

        <div class="pricing-row">

            <span>
                Service Fee
            </span>

            <span>
                $${serviceFee.toFixed(2)}
            </span>

        </div>

        <div class="pricing-row">

            <span id="network-cable-rate">
                Cable — 1 ft × $${pricePerFoot.toFixed(2)}
            </span>

            <span id="network-cable-cost">
                $${pricePerFoot.toFixed(2)}
            </span>

        </div>
        <div class="pricing-row">

            <span>
                Calculation
            </span>

            <span id="network-price-formula">
                $${serviceFee.toFixed(2)}
                + ($${pricePerFoot.toFixed(2)} × 1 ft)
                = $${(serviceFee + pricePerFoot).toFixed(2)}
            </span>

        </div>

        <div class="pricing-row">

            <span>
                Total
            </span>

            <span id="network-price-formula">
                $${(serviceFee + pricePerFoot).toFixed(2)}
            </span>

        </div>
        <div class="pricing-row">
            <a href="/contact">
                <span>Please contact me for a quote!</span>
            </a>
        </div>
    `;

    const feetSlider = document.getElementById(
        'network-cable-feet'
    ) as HTMLInputElement | null;

    const feetNumber = document.getElementById(
        'network-cable-feet-number'
    ) as HTMLInputElement | null;

    const inchesInput = document.getElementById(
        'network-cable-inches'
    ) as HTMLInputElement | null;

    const lengthDisplay = document.getElementById(
        'network-length-display'
    );

    const totalLengthInput = document.getElementById(
        'network-cable-total'
    ) as HTMLInputElement | null;

    const cableRate = document.getElementById(
        'network-cable-rate'
    );

    const cableCost = document.getElementById(
        'network-cable-cost'
    );

    const totalPrice = document.getElementById(
        'network-total-price'
    );

    const formula = document.getElementById(
        'network-price-formula'
    );

    if (
        !feetSlider ||
        !feetNumber ||
        !inchesInput ||
        !lengthDisplay ||
        !totalLengthInput ||
        !cableRate ||
        !cableCost ||
        !totalPrice ||
        !formula
    ) {
        return;
    }

    const updatePrice = (): void => {
        const feet = Number(feetSlider.value);
        const inches = Number(inchesInput.value);

        const exactFeet = feet + inches / 12;

        // Partial feet are billed as the next full foot.
        const billableFeet = Math.ceil(exactFeet);

        const cablePrice = billableFeet * pricePerFoot;

        const estimatedTotal =
            serviceFee + cablePrice;

        const formattedLength =
            `${feet} ft ${inches} in`;

        feetNumber.value = String(feet);

        lengthDisplay.textContent =
            formattedLength;

        totalLengthInput.value =
            formattedLength;

        cableRate.textContent =
            `Cable — ${billableFeet} ft × $${pricePerFoot.toFixed(2)}`;

        cableCost.textContent =
            `$${cablePrice.toFixed(2)}`;

        totalPrice.textContent =
            `$${estimatedTotal.toFixed(2)}`;

        formula.textContent =
            `$${serviceFee.toFixed(2)} + ` +
            `($${pricePerFoot.toFixed(2)} × ${billableFeet} ft) ` +
            `= $${estimatedTotal.toFixed(2)}`;
    };

    feetSlider.addEventListener('input', updatePrice);

    feetNumber.addEventListener('input', () => {
        let feet = Number(feetNumber.value);

        if (feet < 1) {
            feet = 1;
        }

        if (feet > maxFeet) {
            feet = maxFeet;
        }

        feetSlider.value = String(feet);

        updatePrice();
    });

    inchesInput.addEventListener('input', () => {
        let inches = Number(inchesInput.value);

        if (inches < 0) {
            inches = 0;
        }

        if (inches > 11) {
            inches = 11;
        }

        inchesInput.value = String(inches);

        updatePrice();
    });

    updatePrice();
}