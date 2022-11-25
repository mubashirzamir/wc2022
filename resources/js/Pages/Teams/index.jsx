import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, InertiaLink} from '@inertiajs/inertia-react';
import {Button, Table} from 'antd'

export default function Teams(props) {

    const columns = [
        {
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
        {
            title: 'Group',
            dataIndex: 'group',
            key: 'group',
        }
    ];

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Teams</h2>}
        >
            <Head title="Teams"/>


            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div className="pb-3">
                        <InertiaLink href={route("teams.create")}>
                            <Button>Create</Button>
                        </InertiaLink>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Table
                            columns={columns}
                            dataSource={props.teams}
                        />
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
