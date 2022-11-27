import React, {Fragment} from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, InertiaLink} from '@inertiajs/inertia-react';
import {Button} from 'antd'
import {GenericTable} from '@/Components/GenericTable'

export default function Games(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Games</h2>}
        >
            <Head title="Games"/>


            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div className="pb-3">
                        <InertiaLink href={route("games.create")}>
                            <Button>Create</Button>
                        </InertiaLink>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <GamesTable data={props.games}/>
                    </div>

                </div>
            </div>


        </AuthenticatedLayout>
    );
}

export const GamesTable = props => {

    const columns = [
        {
            title: 'Game',
            dataIndex: 'score_line',
            key: 'id',
            render: (score_line, row) =>
                <Fragment>
                    <InertiaLink
                        href={route('games.edit', row.id)}
                    >
                        {score_line}
                    </InertiaLink>

                    <InertiaLink
                        href={route('predictions.index', {game_id: row.id})}
                    >
                        <Button className='float-right'>View Predictions</Button>
                    </InertiaLink>
                </Fragment>
        },
        {
            title: 'Date',
            dataIndex: 'date',
            key: 'date',
        },
    ];

    return (
        <GenericTable columns={columns} data={props.data}/>
    )
}
