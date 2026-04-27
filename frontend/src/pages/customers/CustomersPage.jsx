import { useEffect, useState } from 'react';
import api from '../../api/client';
import EntityTable from '../../components/common/EntityTable';

export default function CustomersPage() {
  const [customers, setCustomers] = useState([]);
  useEffect(() => { api.get('/customers').then((r) => setCustomers(r.data.data)); }, []);

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Customers</h2>
    <EntityTable columns={['Name', 'Phone', 'Email']} rows={customers.map((c) => [c.name, c.phone, c.email || '-'])} />
  </div>;
}
