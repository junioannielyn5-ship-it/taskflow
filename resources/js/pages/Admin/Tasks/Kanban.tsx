import React from 'react';

const Kanban = ({ message }) => {
  return (
    <div style={{ padding: 32 }}>
      <h1>Kanban Board</h1>
      <p>{message || 'Walang laman pa ang Kanban.'}</p>
    </div>
  );
};

export default Kanban;
