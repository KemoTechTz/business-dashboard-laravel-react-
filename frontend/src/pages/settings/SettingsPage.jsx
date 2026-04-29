import { useEffect, useState } from 'react';
import api from '../../api/client';

export default function SettingsPage() {
  const [business, setBusiness] = useState(null);
  const [users, setUsers] = useState([]);

  useEffect(() => {
    api.get('/settings/business').then((r) => setBusiness(r.data));
    api.get('/settings/users').then((r) => setUsers(r.data));
  }, []);

  if (!business) return <p>Loading settings...</p>;

  return <div className="space-y-4">
    <h2 className="text-xl font-semibold">Settings</h2>
    <div className="card">
      <h3 className="font-semibold text-brand-gold">Business Profile</h3>
      <p>{business.name} — {business.location}</p>
      <p>{business.email || 'No email set'} | {business.phone || 'No phone set'}</p>
    </div>
    <div className="card">
      <h3 className="font-semibold text-brand-gold">Team Roles</h3>
      {users.map((u) => <p key={u.id}>{u.name} ({u.role})</p>)}
    </div>
  </div>;
}
