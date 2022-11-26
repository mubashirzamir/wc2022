import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, InertiaLink} from '@inertiajs/inertia-react';
import {Button} from 'antd'
import {GenericTable} from '@/Components/GenericTable'

export default function Users(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Users</h2>}
        >
            <Head title="Users"/>


            <div className="py-4">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div className="pb-3">
                        <InertiaLink href={route("users.create")}>
                            <Button>Create</Button>
                        </InertiaLink>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <UsersTable data={props.users}/>
                    </div>

                </div>
            </div>


        </AuthenticatedLayout>
    );
}

export const UsersTable = props => {

    const columns = [
        {
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
        {
            title: 'No. of Results',
            dataIndex: 'result_count',
            key: 'result_count',

        },
        {
            title: 'No. of Scores',
            dataIndex: 'score_count',
            key: 'score_count',
        },
        {
            title: 'Points',
            dataIndex: 'points',
            key: 'points',
        },
    ];

    return (
        <GenericTable columns={columns} data={props.data}/>
    )
}
