import React, { useContext, useState, useEffect, FC } from 'react';
import {Form, Table, Button, message} from 'antd';

interface IRow {
    id: number;
    name: string;
    config?: any;
}

export const HelloPage: FC = () => {
  const columns = getColumns();

  useEffect(() => {
    fetchData();
  }, []);

  function fetchData() {
    //
  }

  // https://ant.design/components/table/
  return (
    <>
        <Table
          size="small"
          columns={columns}
          pagination={false}
        />
    </>
  );

  // sort by name
  function sortByName(first: IRow, second: IRow) {
    return first.name.localeCompare(second.name);
  }

  function getColumns() {
    const columns = [
      {
        title: 'Id',
        dataIndex: 'id',
      },
      {
        title: 'Name',
        dataIndex: 'name',
        // 預設排序 ascend, descend
        defaultSortOrder: 'descend',
        sorter(first: IRow, second: IRow) {
          if (first.name > second.name) return 1;
          if (first.name < second.name) return -1;
          return 0;
        },
      },
      {
        title: 'Type',
        dataIndex: 'type',
        render: (text: string) => {
          return text.toLowerCase().replace(/(^| )[a-z]/g, function(target) {
            // 開頭大寫
            // -- " aaa BBB"
            // -> " Aaa Bbb"
            return target.toUpperCase();
          });
        },
      },
      {
        title: 'Operations',
        dataIndex: 'operations',
        // eslint-disable-next-line react/display-name
        render: (_text: string, appIntegration: IAppIntegration) => {
          return (
            <span>
              <a onClick={() => openEditDialog(appIntegration)}>Edit</a>
            </span>
          );
        },
      },
    ];

    return columns;
  }
};
