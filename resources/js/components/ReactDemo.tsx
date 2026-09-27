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
