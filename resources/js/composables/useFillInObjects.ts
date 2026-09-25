export default function (source: Record<string, unknown> = {}, data: Record<string, unknown> = {}) {
  const cloneData: Record<string, unknown> = JSON.parse(JSON.stringify(data))

  Object.keys(source).forEach((key) => {
    if (cloneData[key] !== undefined) {
      source[key] = cloneData[key]
    }
  })
}
