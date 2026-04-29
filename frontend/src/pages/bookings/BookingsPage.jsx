import { useEffect, useState } from 'react';
import api from '../../api/client';
import EntityTable from '../../components/common/EntityTable';

export default function BookingsPage() {
  const [bookings, setBookings] = useState([]);
  useEffect(() => { api.get('/bookings').then((r) => setBookings(r.data.data)); }, []);

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Bookings</h2>
    <EntityTable columns={['Customer', 'Service', 'Staff', 'Schedule', 'Status']} rows={bookings.map((b) => [b.customer?.name, b.service?.name, b.staff?.name, new Date(b.scheduled_for).toLocaleString(), b.status])} />
  </div>;
}
