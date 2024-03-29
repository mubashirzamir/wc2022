import React, {useEffect, useState} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/inertia-react';
import {Form, Input, Button, DatePicker, Select, InputNumber, Divider} from 'antd'
import {FormProvider} from 'antd/es/form/context'
import {sanitizeDateTime} from '@/utilities'
import moment from 'moment'

export default function FormComponent(props) {

    const {game, teams} = props
    const editScenario = game !== undefined
    const headerString = editScenario ? 'Edit Game' : 'Create Game'

    const initialValues = {
        date: editScenario ? moment(game?.date) : undefined,
        home_id: editScenario ? game?.home_id : undefined,
        home_score: editScenario ? game?.home_score : undefined,
        away_id: editScenario ? game?.away_id : undefined,
        away_score: editScenario ? game?.away_score : undefined,
        result: editScenario ? game?.result : undefined,
    }

    const [submit, setSubmit] = useState(false)
    const [homeTeam, setHomeTeam] = useState(null)
    const [awayTeam, setAwayTeam] = useState(null)

    const {setData, post, patch} = useForm();

    const onSubmit = (formName, info) => {
        setData(sanitizeDateTime(info.values))
        setSubmit(true)
    }

    useEffect(() => {
        setHomeTeamName()
        setAwayTeamName()
    }, [])

    useEffect(() => {
        if (submit) {
            if (game?.id) {
                patch(route("games.update", game.id))
            } else {
                post(route("games.store"))
            }
        }
    }, [submit])

    const [form] = Form.useForm();

    const handleFormValuesChange = (changedValues) => {
        const formFieldName = Object.keys(changedValues)[0];
        if (formFieldName === 'home_id') {
            setHomeTeamName()
        } else if (formFieldName === 'away_id') {
            setAwayTeamName()
        }
    }

    const setHomeTeamName = () => {
        const team = teams.find(team => team.value === form.getFieldValue('home_id'))
        if (team) {
            setHomeTeam(team.label)
        }
    }

    const setAwayTeamName = () => {
        const team = teams.find(team => team.value === form.getFieldValue('away_id'))
        if (team) {
            setAwayTeam(team.label)
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
                            <Form.Item name="date"
                                       label="Date"
                                       rules={[{required: true, message: 'Please select the date.'}]}
                            >
                                <DatePicker/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="home_id"
                                label="Team 01"
                                rules={[{required: true, message: 'Please select a team'}]}
                            >
                                <Select
                                    placeholder="Please select a team"
                                    disabled={editScenario}
                                    options={teams}
                                />
                            </Form.Item>

                            <Form.Item name="home_score"
                                       label="Team 01 Score"
                            >
                                <InputNumber/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="away_id"
                                label="Team 02"
                                rules={[{required: true, message: 'Please select a team'}]}
                            >
                                <Select
                                    placeholder="Please select a team"
                                    disabled={editScenario}
                                    options={teams}
                                />
                            </Form.Item>

                            <Form.Item name="away_score"
                                       label="Team 02 Score"
                            >
                                <InputNumber defaultValue={editScenario ? game?.away_score : undefined}/>
                            </Form.Item>

                            <Divider/>

                            <Form.Item
                                name="result"
                                label="Result"
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
