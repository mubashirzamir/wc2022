import {Table} from 'antd'
import React from 'react'

export const GamesTable = props => {

    const gameColumns = [
        {
            title: 'Match',
            dataIndex: 'score_string',
            key: 'id',
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

    return (
        <Table
            columns={gameColumns}
            dataSource={props.games}
        />
    )

}
