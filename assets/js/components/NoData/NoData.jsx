import React, { Component } from 'react'
import NoTasksImage from '~/images/no_data.svg'

export default class NoData extends Component {
    render() {
        return (
            <div className="image--container">
                <h2>You do not have tasks yet. Add one now!</h2>
                <img src={ NoTasksImage } alt="no_tasks_image" />
            </div>
        )
    }
}