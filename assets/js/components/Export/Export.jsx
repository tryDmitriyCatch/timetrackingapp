import React from 'react'
import { Form, Formik } from 'formik'
import WorkspaceNavigation from '~/js/components/WorkspaceNavigation'
import PDF from '~/images/pdf.svg'
import SVG from '~/images/csv.svg'
import { ExportTypes } from '~/js/config'
import DatePicker from 'react-datepicker'
import 'react-datepicker/dist/react-datepicker.css'

export default class Export extends React.Component {
    constructor(props) {
        super(props)

        this.state = {
            exportType: '',
            pdfClicked: false,
            csvClicked: false,
            fromDate: new Date(),
            toDate: null,
            success: true
        }

        console.log(props)
    }

    handleTypeSelect(type) {
        if (type === 'pdf') {
            this.setState({
                pdfClicked: true,
                csvClicked: false,
                success: true
            })
        } else {
            this.setState({
                csvClicked: true,
                pdfClicked: false,
                success: true
            })
        }
        this.setState({
            exportType: type
        })
    }

    onSubmit() {
        let fromDate = this.state.fromDate.toISOString().slice(0,10);
        let toDate = this.state.toDate.toISOString().slice(0,10);

        if (this.state.exportType === '') {
            this.setState({ success: false })
            return
        }

        this.setState({ success: true })

        const url = `/api/export?userId=${this.props.userEntity.id}&fromDate=${fromDate}&toDate${toDate}&format=${this.state.exportType}`

        window.open(url, '_blank')
    }

    render() {
        return (
            <div id="page-container">
                <WorkspaceNavigation userEntity={ this.props.userEntity }/>
                <div className="row" id="export--form--container">
                    <div className="col-md-6" id="export--form--container--inner">
                        <h4>Let's export some tasks</h4>
                        { !this.state.success &&
                        <div className="error__container">
                            <p className="lead">Please choose file format</p>
                        </div>
                        }
                        <Formik
                            noValidate
                            initialValues={{}}
                            onSubmit={ () => this.onSubmit() }>
                            { () => (
                                <Form>
                                    <div id="export--type--group">
                                        <div className={ this.state.pdfClicked
                                            ? "export--type--input--clicked"
                                            : "export--type--input"
                                        } onClick={() => this.handleTypeSelect(ExportTypes.PDF) }>
                                            <img src={ PDF } alt="pdf icon"/>
                                        </div>
                                        <div className={ this.state.csvClicked
                                            ? "export--type--input--clicked"
                                            : "export--type--input"
                                        } onClick={() => this.handleTypeSelect(ExportTypes.CSV) }>
                                            <img src={ SVG } alt="pdf icon"/>
                                        </div>
                                    </div>

                                    <div className="form-row">
                                        <div className="form-group col-md-6">
                                            <label htmlFor="fromDate">From Date</label>
                                            <DatePicker
                                                dateFormat="yyyy/MM/dd"
                                                selected={ this.state.fromDate }
                                                onChange={ date => this.setState({ fromDate: date }) }
                                                className="form-control"
                                                name="from"
                                                id="fromDate"
                                            />
                                        </div>
                                        <div className="form-group col-md-6">
                                            <label htmlFor="toDate">To Date</label>
                                            <DatePicker
                                                dateFormat="yyyy/MM/dd"
                                                selected={ this.state.toDate }
                                                onChange={ date => this.setState({ toDate: date }) }
                                                className="form-control"
                                                name="to"
                                                id="toDate"
                                            />
                                        </div>
                                    </div>
                                    <div className="text-center">
                                        <button type="submit" className="btn btn--primary login--button">Export</button>
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