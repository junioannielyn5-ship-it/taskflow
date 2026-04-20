import React from 'react';

const Create = () => {
  const [taskName, setTaskName] = React.useState("");
  const [description, setDescription] = React.useState("");
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    alert(`Task Created!\nName: ${taskName}\nDescription: ${description}`);
    // Dito ilalagay ang API call o logic para mag-save ng task
  };
  return (
    <div className="mx-auto mt-10 max-w-lg rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
      <h1 className="mb-6 text-xl font-semibold text-gray-900">Create Task Page</h1>
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="mb-1 block text-sm font-medium text-gray-700">Task Name:</label>
          <input
            type="text"
            value={taskName}
            onChange={e => setTaskName(e.target.value)}
            className="w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500"
            placeholder="Enter task name..."
            required
          />
        </div>
        <div>
          <label className="mb-1 block text-sm font-medium text-gray-700">Description:</label>
          <textarea
            value={description}
            onChange={e => setDescription(e.target.value)}
            className="w-full rounded-lg border border-gray-300 bg-white p-2 text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500"
            placeholder="Enter description..."
            rows={4}
            required
          />
        </div>
        <button
          type="submit"
          className="w-full rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Create Task
        </button>
      </form>
    </div>
  );
};

export default Create;
