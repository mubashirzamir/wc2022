import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/inertia-react';
import {Form, Input, Button, DatePicker, TimePicker, Select, InputNumber, Divider} from 'antd'
import {FormProvider} from 'antd/es/form/context'
import {sanitizeDateTime} from '@/utilities'

export default function FormComponent(props) {

    const [submit, setSubmit] = useState(false)

    const {setData, post} = useForm();

    const onSubmit = (formName, info) => {
        setData(sanitizeDateTime(info.values))
        setSubmit(true)
    }

    useEffect(() => {
        if (submit) post(route("games.store"))
    }, [submit])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Game</h2>}
        >
            <Head title="Create Game"/>

            <div className="py-4 px-2">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <FormProvider onFormFinish={(formName, info) => onSubmit(formName, info)}>
                        <Form>
                            <Form.Item name="date"
                                       label="Date"
                                       rules={[{required: true, message: 'Please select the date.'}]}
                            >
                                <DatePicker/>
                            </Form.Item>

                            <Form.Item name="time"
                                       label="Time"
                                // rules={[{required: true, message: 'Please select the time.'}]}
                            >
                                <TimePicker/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="home_id"
                                label="Team 01"
                                rules={[{required: true, message: 'Please select a team'}]}
                            >
                                <Select placeholder="Please select a team" options={props.teams}/>
                            </Form.Item>

                            <Form.Item name="home_score"
                                       label="Team 01 Score"
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="away_id"
                                label="Team 02"
                                rules={[{required: true, message: 'Please select a team'}]}
                            >
                                <Select placeholder="Please select a team" options={props.teams}/>
                            </Form.Item>

                            <Form.Item name="away_score"
                                       label="Team 02 Score"
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="result"
                                label="Result"
                                rules={[{required: true, message: 'Please select a result'}]}
                            >
                                <Select placeholder="Please select a result">
                                    <Option value="h">Team 01 Win</Option>
                                    <Option value="a">Team 02 Win</Option>
                                    <Option value="d">Draw</Option>
                                </Select>
                            </Form.Item>

                            <Form.Item className="float-right">
                                <Button htmlType="submit">
                                    Submit
                                </Button>
                            </Form.Item>
                        </Form>
                    </FormProvider>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
