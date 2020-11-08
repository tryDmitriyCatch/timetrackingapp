import React from 'react'
import { BrowserRouter, Switch, Route } from 'react-router-dom'
import { ROUTE_PATHS, ROUTE_NAMES } from '~/js/routes/config'
import Login from '~/js/components/Login'
import Workspace from '~/js/components/Workspace'
import Homepage from '~/js/components/Homepage'
import AddTaskForm from '~/js/components/AddTaskForm'
import Export from '~/js/components/Export'

export default class LandingRoute extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            userEntity: null,
        }
    }

    setUserEntity = userEntity => {
        this.setState({ userEntity: userEntity })
    }

    render() {
        return <div id="page-container">
            <BrowserRouter>
                <Switch>
                    <Route exact path={ROUTE_PATHS.get(ROUTE_NAMES.HOME)} component={ Homepage }/>
                    <Route exact path={ROUTE_PATHS.get(ROUTE_NAMES.LOGIN)}>
                        <Login userEntity={ this.state.userEntity } setUserEntity={ this.setUserEntity }/>
                    </Route>
                    <Route exact path={ROUTE_PATHS.get(ROUTE_NAMES.WORKSPACE)}>
                        <Workspace userEntity={ this.state.userEntity } setUserEntity={ this.setUserEntity }/>
                    </Route>
                    <Route exact path={ROUTE_PATHS.get(ROUTE_NAMES.ADD_TASK)}>
                        <AddTaskForm userEntity={ this.state.userEntity } setUserEntity={ this.setUserEntity }/>
                    </Route>
                    <Route exact path={ROUTE_PATHS.get(ROUTE_NAMES.EXPORT)}>
                        <Export userEntity={ this.state.userEntity } setUserEntity={ this.setUserEntity }/>
                    </Route>
                </Switch>
            </BrowserRouter>
        </div>
    }
}