/* RabbitMQ */
const amqp = require("amqplib");

const msg = { text: process.argv[2] };
connect();
async function connect() {
  try {
    amqpServer = "amqp://localhost:5672";
    connection = await amqp.connect(amqpServer);
    channel = await connection.createChannel();
    await channel.assertQueue("JOB_SERVICE");
    channel.sendToQueue("JOB_SERVICE", Buffer.from(JSON.stringify(msg)));
    console.log(`Job sent successfully ${msg.text}`);
    await channel.close();
    await connection.close();
  } catch (ex) {
    console.error(ex);
  }
}
