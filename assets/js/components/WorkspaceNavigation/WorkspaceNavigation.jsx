import React from 'react'
import { generatePath } from '~/js/routes/router'
import { ROUTE_NAMES } from '~/js/routes/config'
import { Link } from 'react-router-dom'

export default class WorkspaceNavigation extends React.Component {
    constructor(props) {
        super(props)
    }

    render() {
        return (
            <div className="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white inner--navigation">
                <h5 className="my-0 mr-md-auto font-weight-normal">Welcome</h5>
                <nav className="my-2 my-md-0 mr-md-3">
                    <a className="p-2 text-dark" href="/logout">Logout</a>
                    <Link
                        className="p-2 text-dark"
                        to={ generatePath(ROUTE_NAMES.EXPORT) }>
                        Export tasks
                    </Link>
                </nav>
                <Link
                    className="login__button"
                    to={ generatePath(ROUTE_NAMES.ADD_TASK) }>
                    Add Task
                </Link>
            </div>
        )
    }
}