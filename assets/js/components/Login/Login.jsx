import React, { Component } from 'react'
import {
    ErrorMessage,
    Field,
    Form,
    Formik
} from 'formik'
import * as Yup from 'yup'
import apiClient from '~/js/utils/apiClient'
import { Redirect } from 'react-router-dom'
import { ROUTE_PATHS, ROUTE_NAMES } from '~/js/routes/config'

export default class Login extends Component {
    constructor(props) {
        super(props);

        this.state = {
            isUserAuthenticated: false,
            userEntity: '',
            status: '',
            message: '',
            showSuccessMessage: false
        }
    }

    onSubmit(values) {
        let formData = new FormData

        formData.append('email', values.email)
        formData.append('password', values.password)
        formData.append('csrf_token', values.hiddenField)

        return apiClient
            .post(`/login`, formData)
            .then((response) => {
                if (response.data.status === 'success') {
                    this.setState({
                        showSuccessMessage: true
                    })
                    setTimeout(() => {
                        this.setUserEntity(response.data.user)
                        this.handleSuccessfullLogin(response)
                    }, 3000)
                } else {
                    this.setState({
                        isUserAuthenticated: false,
                        status: response.data.status,
                        message: response.data.message
                    })
                }
            })
    }

    setUserEntity(response) {
        this.props.setUserEntity(response)
    }

    handleSuccessfullLogin(response) {
        this.setState({
            showSuccessMessage: false,
            isUserAuthenticated: true,
            userEntity: response.data.user,
            status: response.data.status
        })
    }

    initialValues = {
        email: '',
        password: '',
        hiddenField: csrf_token.token
    }

    validationSchema = Yup.object().shape({
        email: Yup.string()
            .required('Please enter your email'),
        password: Yup.string()
            .required('Please enter your password')
    })

    render() {
        if (this.state.isUserAuthenticated) {
            return <Redirect
                to={{
                    pathname: ROUTE_PATHS.get(ROUTE_NAMES.WORKSPACE),
                    state: { userEntity: this.state.userEntity }
                }}
            />
        }

        return <div className="container">
            <div className="row" id="login__container">
                <div className="col-md-6" id="form__container">
                    { this.state.status === 'error' && !this.state.showSuccessMessage &&
                    <div className="error__container">
                        <p className="lead">{ this.state.message }</p>
                    </div>
                    }
                    { this.state.showSuccessMessage &&
                    <div className="success__container">
                        <p className="lead">Success! Logging you in...</p>
                    </div>
                    }
                    <h4>Please login to your account</h4>
                    <hr />
                    <Formik
                        initialValues={ this.initialValues }
                        validationSchema={ this.validationSchema }
                        onSubmit={(values) => this.onSubmit(values)}
                    >
                        { props => (
                            <Form className="form__content">
                                <Field
                                    type="hidden"
                                    className="form-control"
                                    name="hiddenField"
                                    value={ props.values.csrf_token }
                                />
                                <ErrorMessage className="contact_form__error" name="email" component="span" />
                                <Field
                                    className="form-control"
                                    type="email"
                                    name="email"
                                    id="email"
                                    placeholder="Your Email"
                                    value={ props.values.email }
                                    onChange={ props.handleChange }
                                />

                                <ErrorMessage className="contact_form__error" name="password" component="span" />
                                <Field
                                    className="form-control"
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    value={ props.values.password }
                                    onChange={ props.handleChange }
                                />
                                <div className="text-center">
                                    <button type="submit" className="btn btn--primary login--button">Login</button>
                                </div>
                            </Form>
                        )}
                    </Formik>
                </div>
            </div>
        </div>
    }
}