import {Table} from 'antd'
import React from 'react'

export const GenericTable = props => {

    return (
        <Table
            columns={props.columns}
            dataSource={props.data}
            scroll={{ x: 400 }}
        />
    )

}
