import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/inertia-react';
import {Form, Input, Button} from 'antd'
import {FormProvider} from 'antd/es/form/context'

export default function FormComponent(props) {

    const [submit, setSubmit] = useState(false)

    const {setData, post} = useForm();

    const onSubmit = (formName, info) => {
        setData(info.values)
        setSubmit(true)
    }

    useEffect(() => {
        if (submit) post(route("teams.store"))
    }, [submit])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Team</h2>}
        >
            <Head title="Create Team"/>

            <div className="py-4 px-2">
                <FormProvider onFormFinish={(formName, info) => onSubmit(formName, info)}>
                    <Form>
                        <Form.Item
                            label="Name"
                            name="name"
                            rules={[{required: true, message: 'Please input team name'}]}
                        >
                            <Input/>
                        </Form.Item>

                        <Form.Item
                            label="Group"
                            name="group"
                        >
                            <Input/>
                        </Form.Item>

                        <Form.Item className="float-right">
                            <Button htmlType="submit">
                                Submit
                            </Button>
                        </Form.Item>
                    </Form>
                </FormProvider>
            </div>

        </AuthenticatedLayout>
    );
}
