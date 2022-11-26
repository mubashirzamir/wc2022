import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, InertiaLink} from '@inertiajs/inertia-react';
import {Button} from 'antd'
import {GenericTable} from '@/Components/GenericTable'

export default function Predictions(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Predictions</h2>}
        >
            <Head title="Predictions"/>


            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div className="pb-3">
                        <InertiaLink href={route("predictions.create")}>
                            <Button>Create</Button>
                        </InertiaLink>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <PredictionsTable {...props}/>
                    </div>

                </div>
            </div>


        </AuthenticatedLayout>
    );
}

export const PredictionsTable = props => {

    const columns = [
        {
            title: 'Player',
            dataIndex: 'user',
            filters: props.users,
            onFilter: (value, record) => record.user_id === value,
            render: (user => user.name),
        },
        {
            title: 'Prediction',
            dataIndex: 'predicted_score_line',
            key: 'id',
            render: (predicted_score_line, row) =>
                <InertiaLink
                    href={route('predictions.edit', row.id)}
                >
                    {predicted_score_line}
                </InertiaLink>,
        },
        {
            title: 'Result',
            dataIndex: 'game',
            render: (game => game.score_line)
        },
        {
            title: 'Points',
            dataIndex: 'points',
            key: 'points',
        },
    ];

    return (
        <GenericTable columns={columns} data={props.predictions}/>
    )
}
