import React from 'react'
import { generatePath } from '~/js/routes/router'
import { ROUTE_NAMES } from '~/js/routes/config'
import { Link } from 'react-router-dom'

export default class Navigation extends React.Component {
    render() {
        return (
            <section id="nav-bar">
                <header className="navigation--header">
                    <Link className="login__button" to={ generatePath(ROUTE_NAMES.LOGIN) }>Login</Link>
                </header>
            </section>
        )
    }
}