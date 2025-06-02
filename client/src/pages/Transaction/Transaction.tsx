import React from 'react'
import TransactionTable from '../../components/TransactionTable'
import Sidebar from '../../components/Sidebar'

const Transaction = () => {
  return (

   <div className="min-h-screen bg-gray-100 flex">
      <Sidebar />
      

        
        <div >
          <TransactionTable />
         
        </div>

        <div></div>
      </div>
  )
}

export default Transaction
