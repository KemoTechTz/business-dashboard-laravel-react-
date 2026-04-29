import { useEffect, useState } from 'react';
import api from '../../api/client';
import EntityTable from '../../components/common/EntityTable';

export default function ServicesPage() {
  const [services, setServices] = useState([]);
  useEffect(() => { api.get('/services').then((r) => setServices(r.data.data)); }, []);

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Services & Products</h2>
    <EntityTable columns={['Name', 'Category', 'Price (TZS)', 'Status']} rows={services.map((s) => [s.name, s.category, s.price_tzs, s.is_active ? 'Active' : 'Inactive'])} />
  </div>;
}
