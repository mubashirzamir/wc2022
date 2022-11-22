import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/inertia-react';
import {Table} from 'antd'

export default function Dashboard(props) {

    const gameColumns = [
        {
            title: 'Home ID',
            dataIndex: 'home_id',
            key: 'home_id',
        },
        {
            title: 'Away ID',
            dataIndex: 'away_id',
            key: 'away_id',
        },
        {
            title: 'Date',
            dataIndex: 'date',
            key: 'date',
        },
        {
            title: 'Time',
            dataIndex: 'time',
            key: 'time',
        },
    ];

    const userColumns = [
        {
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
        {
            title: 'Points',
            dataIndex: 'points',
            key: 'points',
        },
    ];


    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard"/>

            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Table
                            columns={gameColumns}
                            dataSource={props.games}
                        />
                    </div>
                </div>
            </div>

            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Table
                            columns={userColumns}
                            dataSource={props.users}
                        />
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
