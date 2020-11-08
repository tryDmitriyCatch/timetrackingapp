import React from 'react'
import WorkspaceNavigation from '~/js/components/WorkspaceNavigation'
import {ErrorMessage, Field, Form, Formik} from 'formik'
import * as Yup from 'yup'
import { Redirect } from 'react-router-dom'
import apiClient from '~/js/utils/apiClient'
import { ROUTE_PATHS, ROUTE_NAMES } from '~/js/routes/config'

export default class AddTaskForm extends React.Component {
    constructor(props) {
        super(props)

        this.state = {
            hasTaskHasBeenAdded: false,
            isTaskAddedSuccessfully: false,
            status: '',
            user: ''
        }
    }

    onSubmit(values) {
        let formData = new FormData

        formData.append('title', values.title)
        formData.append('description', values.description)
        formData.append('timeSpent', values.timeSpent)
        formData.append('userId', this.props.userEntity.id)

        return apiClient
            .post(`/user_add_task`, formData)
            .then((response) => {
                if (response.data.status === 'success') {
                    this.setState({
                        hasTaskHasBeenAdded: true,
                        isTaskAddedSuccessfully: true,
                        status: response.data.status,
                        user: response.data.user
                    })
                } else {
                    this.setState({
                        hasTaskHasBeenAdded: false,
                        isTaskAddedSuccessfully: false,
                        status: response.data.status
                    })
                }
            })
    }

    initialValues = {
        title: '',
        description: '',
        timeSpent: ''
    }

    validationSchema = Yup.object().shape({
        title: Yup.string()
            .required('Please add title'),
        description: Yup.string()
            .required('Please add description'),
        timeSpent: Yup.string()
            .required('Please add time')
    })

    render() {
        if (this.state.hasTaskHasBeenAdded && this.state.isTaskAddedSuccessfully) {
            return <Redirect
                to={{
                    pathname: ROUTE_PATHS.get(ROUTE_NAMES.WORKSPACE),
                    state: { userEntity: this.state.user }
                }}
            />
        }

        return (
            <div id="page-container">
                <WorkspaceNavigation userEntity={ this.props.userEntity }/>
                <div className="row" id="task--form--container">
                    <div className="col-md-6" id="task--form--container--inner">
                        <h4>Let's add some tasks</h4>
                        <Formik
                            initialValues={ this.initialValues }
                            validationSchema={ this.validationSchema }
                            onSubmit={(values) => this.onSubmit(values)}
                        >
                            { props => (
                                <Form className="form__content">
                                    <ErrorMessage className="contact_form__error" name="title" component="span" />
                                    <Field
                                        className="form-control"
                                        type="text"
                                        name="title"
                                        id="title"
                                        placeholder="Title"
                                        value={ props.values.title }
                                        onChange={ props.handleChange }
                                    />

                                    <ErrorMessage className="contact_form__error" name="description" component="span" />
                                    <Field
                                        className="form-control"
                                        type="text"
                                        name="description"
                                        id="description"
                                        placeholder="Description"
                                        value={ props.values.description }
                                        onChange={ props.handleChange }
                                    />

                                    <ErrorMessage className="contact_form__error" name="timeSpent" component="span" />
                                    <Field
                                        className="form-control"
                                        type="text"
                                        name="timeSpent"
                                        id="timeSpent"
                                        placeholder="Time Spent"
                                        value={ props.values.timeSpent }
                                        onChange={ props.handleChange }
                                    />
                                    <div className="text-center">
                                        <button type="submit" className="btn btn--primary login--button">Add task</button>
                                    </div>
                                </Form>
                            )}
                        </Formik>
                    </div>
                </div>
            </div>
        )
    }
}