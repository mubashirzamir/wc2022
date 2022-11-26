import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/inertia-react';
import {Button, Divider, Form, InputNumber, Select} from 'antd'
import {FormProvider} from 'antd/es/form/context'

export default function FormComponent(props) {

    const {prediction} = props
    const editScenario = prediction !== undefined
    const headerString = editScenario ? 'Edit Prediction' : 'Create Prediction'

    const initialValues = {
        user_id: editScenario ? prediction?.user_id : undefined,
        game_id: editScenario ? prediction?.game_id : undefined,
        home_score: editScenario ? prediction?.home_score : undefined,
        away_score: editScenario ? prediction?.away_score : undefined,
        result: editScenario ? prediction?.result : undefined,
    }

    const [submit, setSubmit] = useState(false)

    const {setData, post, patch} = useForm();

    const onSubmit = (formName, info) => {
        setData(info.values)
        setSubmit(true)
    }

    useEffect(() => {
        if (submit) {
            if (prediction?.id) {
                patch(route("predictions.update", prediction.id))
            } else {
                post(route("predictions.store"))
            }
        }
    }, [submit])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{headerString}</h2>}
        >
            <Head title={headerString}/>

            <div className="py-4 px-2">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <FormProvider onFormFinish={(formName, info) => onSubmit(formName, info)}>
                        <Form initialValues={initialValues}>

                            <Form.Item
                                name="user_id"
                                label="Player"
                                rules={[{required: true, message: 'Please select a player'}]}
                            >
                                <Select
                                    placeholder="Please select a player"
                                    disabled={editScenario}
                                    options={props.users}
                                />
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="game_id"
                                label="Game"
                                rules={[{required: true, message: 'Please select a team'}]}
                            >
                                <Select
                                    placeholder="Please select a game"
                                    disabled={editScenario}
                                    options={props.games}
                                />
                            </Form.Item>

                            <Form.Item name="home_score"
                                       label="Team 01 Score"
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

                            <Form.Item name="away_score"
                                       label="Team 02 Score"
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

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
