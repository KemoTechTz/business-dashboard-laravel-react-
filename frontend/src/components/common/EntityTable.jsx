export default function EntityTable({ columns, rows }) {
  return (
    <div className="card overflow-x-auto">
      <table className="min-w-full text-sm">
        <thead>
          <tr className="text-left text-zinc-400">
            {columns.map((c) => <th className="px-3 py-2" key={c}>{c}</th>)}
          </tr>
        </thead>
        <tbody>
          {rows.map((row, idx) => (
            <tr key={idx} className="border-t border-zinc-800">
              {row.map((cell, i) => <td className="px-3 py-2" key={i}>{cell}</td>)}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
