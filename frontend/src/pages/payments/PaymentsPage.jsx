import { useEffect, useState } from 'react';
import api from '../../api/client';
import EntityTable from '../../components/common/EntityTable';

export default function PaymentsPage() {
  const [payments, setPayments] = useState([]);
  useEffect(() => { api.get('/payments').then((r) => setPayments(r.data.data)); }, []);

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Payments</h2>
    <EntityTable columns={['Booking', 'Amount', 'Method', 'Status']} rows={payments.map((p) => [p.booking_id, p.amount_tzs, p.method, p.status])} />
  </div>;
}
