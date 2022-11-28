import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/inertia-react';
import {Button, Divider, Form, InputNumber, Select} from 'antd'
import {FormProvider} from 'antd/es/form/context'

export default function FormComponent(props) {

    const {prediction, games} = props
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
    const [homeTeam, setHomeTeam] = useState(null)
    const [awayTeam, setAwayTeam] = useState(null)

    const {setData, post, patch} = useForm();

    const onSubmit = (formName, info) => {
        setData(info.values)
        setSubmit(true)
    }

    useEffect(() => {
        setTeamNames()
    }, [])

    useEffect(() => {
        setTeamNames()
        if (submit) {
            if (prediction?.id) {
                patch(route("predictions.update", prediction.id))
            } else {
                post(route("predictions.store"))
            }
        }
    }, [submit])

    const [form] = Form.useForm();

    const handleFormValuesChange = (changedValues) => {
        const formFieldName = Object.keys(changedValues)[0];
        if (formFieldName === 'game_id') {
            setTeamNames()
        }
    }

    const setTeamNames = () => {
        const game = games.find(game => game.value === form.getFieldValue('game_id'))
        /**
         * https://stackoverflow.com/questions/650022/how-do-i-split-a-string-with-multiple-separators-in-javascript
         */
        if (game) {
            const teamNames = game.label.toString().split(/(?:,|vs)+/)
            setHomeTeam(teamNames[0])
            setAwayTeam(teamNames[1])
        }
    }

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
                        <Form form={form} onValuesChange={handleFormValuesChange} initialValues={initialValues}>

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
                                    options={games}
                                />
                            </Form.Item>

                            <Form.Item name="home_score"
                                       label={homeTeam ? homeTeam + ' score' : 'Team 01 score'}
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

                            <Form.Item name="away_score"
                                       label={awayTeam ? awayTeam + ' score' : 'Team 02 score'}
                                       rules={[{required: true, type: 'number', min: 0, max: 99}]}>
                                <InputNumber/>
                            </Form.Item>

                            <Form.Item
                                name="result"
                                label="Result"
                                rules={[{required: true, message: 'Please select a result'}]}
                            >
                                <Select placeholder="Please select a result">
                                    <Select.Option value="h">{homeTeam}</Select.Option>
                                    <Select.Option value="a">{awayTeam}</Select.Option>
                                    <Select.Option value="d">Draw</Select.Option>
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
