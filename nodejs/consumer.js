const amqp = require("amqplib");

connect();
async function connect() {
  try {
    amqpServer = "amqp://localhost:5672";
    connection = await amqp.connect(amqpServer);
    channel = await connection.createChannel();
    await channel.assertQueue("JOB_SERVICE");

    channel.consume("JOB_SERVICE", (message) => {
      mesage = JSON.parse(message.content.toString());
      console.log(`Recieved job with input ${mesage.text}`);
      channel.ack(message);
    });

    console.log("Waiting for messages...");
  } catch (ex) {
    console.error(ex);
  }
}
