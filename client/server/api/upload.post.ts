import path from 'path'
import fs from 'fs'
export default defineEventHandler(async(event) => {
    const files = await readMultipartFormData(event)

    const uploadedFilePaths: string[] = []

    files?.forEach((file) => {
        const filePath = path.join(process.cwd(), 'public', file.filename as string)
        fs.writeFileSync(filePath, file.data)
        uploadedFilePaths.push(`/${file.filename}`)
    })
    return uploadedFilePaths
})