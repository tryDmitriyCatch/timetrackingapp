import React, { Component } from 'react'
import apiClient from '~/js/utils/apiClient'
import TaskTable from '../TaskTable'
import WorkspaceNavigation from '~/js/components/WorkspaceNavigation'

export default class Workspace extends Component {
    constructor(props) {
        super(props)

        this.state = {
            userHasTasks: false,
            tasksArray: []
        }
    }

    componentDidMount() {
        this.parseUsersTasks()
    }

    parseUsersTasks() {
        return apiClient
            .get(`/fetch_tasks?userId=${ this.props.userEntity.id }`)
            .then((response) => {
                if (response.data.status === 'success' && response.data.data.length !== 0) {
                    this.setState({
                        userHasTasks: true,
                        tasksArray: response.data.data
                    })
                }
            })
    }

    render() {
        return <div id="workspace">
            <WorkspaceNavigation userEntity={ this.props.userEntity }/>
            <section id="homepage">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-lg-12" id="table--container">
                            <TaskTable data={ this.state.tasksArray }/>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    }
}