import React, { Component } from 'react'
import NoData from '~/js/components/NoData'
import DataTable from 'react-data-table-component'

export default class TaskTable extends Component {
    constructor(props) {
        super(props)
    }

    componentDidMount() {
        this.fetchUserTasks()
    }

    fetchUserTasks() {
        return [
            { title: this.props.data.title },
            { description: this.props.data.description },
            { timeSpent: this.props.data.timeSpent }
        ]
    }


    render() {
        const columns = [
            {
                name: 'Title',
                selector: 'title'
            },
            {
                name: 'Description',
                selector: 'description'
            },
            {
                name: 'Time Spent',
                selector: 'timeSpent'
            },
        ];

        const data = this.props.data;

        return(
            <main role="main">
                { this.props.data.length === 0
                    ?   <NoData />
                    :
                    <DataTable
                        title="All Tasks"
                        columns={ columns }
                        data={ data }
                        pagination={ true }
                        paginationServer={ false }
                        paginationPerPage={ 5 }
                    />
                }
            </main>
        )
    }
}