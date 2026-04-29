import { useEffect, useState } from 'react';
import { Area, AreaChart, ResponsiveContainer, Tooltip, XAxis, YAxis } from 'recharts';
import api from '../../api/client';

export default function DashboardPage() {
  const [data, setData] = useState(null);
  const [error, setError] = useState('');

  useEffect(() => {
    api.get('/dashboard/summary')
      .then((res) => setData(res.data))
      .catch(() => setError('Failed to load dashboard metrics.'));
  }, []);

  const downloadReport = async (format) => {
    const response = await api.get(`/dashboard/export/${format}`, {
      responseType: format === 'csv' ? 'blob' : 'json'
    });

    if (format === 'json') {
      const blob = new Blob([JSON.stringify(response.data, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'dashboard-report.json';
      a.click();
      URL.revokeObjectURL(url);
      return;
    }

    const url = URL.createObjectURL(response.data);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'dashboard-report.csv';
    a.click();
    URL.revokeObjectURL(url);
  };

  if (error) return <p className="text-red-400">{error}</p>;
  if (!data) return <p>Loading dashboard...</p>;

  return <div className="space-y-4">
    <div className="flex items-center justify-between">
      <h2 className="text-2xl font-bold">Dashboard Overview</h2>
      <div className="flex gap-2">
        <button onClick={() => downloadReport('csv')} className="rounded bg-zinc-800 px-3 py-1 text-sm">Export CSV</button>
        <button onClick={() => downloadReport('json')} className="rounded bg-zinc-800 px-3 py-1 text-sm">Export JSON</button>
      </div>
    </div>
    <div className="grid gap-4 md:grid-cols-3">
      <div className="card"><p>Total Revenue</p><h3 className="text-2xl text-brand-gold">TZS {Number(data.total_revenue_tzs).toLocaleString()}</h3></div>
      <div className="card"><p>Active Customers</p><h3 className="text-2xl">{data.active_customers}</h3></div>
      <div className="card"><p>Bookings</p><h3 className="text-2xl">{data.bookings_count}</h3></div>
    </div>
    <div className="card h-72">
      <ResponsiveContainer width="100%" height="100%">
        <AreaChart data={data.daily_revenue}>
          <XAxis dataKey="day" stroke="#a1a1aa" />
          <YAxis stroke="#a1a1aa" />
          <Tooltip />
          <Area type="monotone" dataKey="total" stroke="#d4af37" fill="#d4af3788" />
        </AreaChart>
      </ResponsiveContainer>
    </div>
  </div>;
}
