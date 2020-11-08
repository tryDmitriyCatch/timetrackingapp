import React from 'react'
import Hero from '~/images/hero1.jpg'
import { generatePath } from '~/js/routes/router'
import { ROUTE_NAMES } from '~/js/routes/config'
import { Link } from 'react-router-dom'
import Navigation from '~/js/components/Navigation'

export default class Homepage extends React.Component {
    render() {
        return <div id="page-container">
            <Navigation />
            <section id="homepage">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-lg-6 hero__section">
                            <img src={ Hero } alt="hero_image" />
                        </div>
                        <div className="col-lg-6 intro__section">
                            <div className="desc">
                                <h1>Time Tracker</h1>
                                <p>
                                    You can use this app to create tasks and track the time.
                                    Please login to get started
                                </p>
                                <Link className="login__button" to={ generatePath(ROUTE_NAMES.LOGIN) }>Try it out</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    }
}